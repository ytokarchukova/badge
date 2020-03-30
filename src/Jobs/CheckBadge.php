<?php

namespace YTokarchukova\Badge\Jobs;

use Exception;
use YTokarchukova\Badge\Models\Badge;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\DomCrawler\Crawler;

class CheckBadge implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 2;
    public $retryAfter = 120;

    protected $badge;
    protected $check_address;

    /**
     * Create a new job instance.
     *
     * @param Badge $badge
     * @param $check_address
     * @param int $retryAfter
     * @param int $tries
     */
    public function __construct(Badge $badge, $check_address, $retryAfter = 120, $tries = 2) {

        $this->badge = $badge;
        $this->check_address = $check_address;

        $this->retryAfter = $retryAfter;
        $this->tries = $tries;

    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws Exception
     */
    public function handle() {

        $client_args = array(
            'allow_redirects' => true,
            'timeout' => 90,
        );

        $client = new Client();

        $response = $client->request('GET', 'https://' . $this->check_address, $client_args);

        if ($response->getStatusCode() !== 200) {
            throw new Exception('Get Site Error');
        }

        $html_content = $response->getBody()->getContents();

        $crawler = new Crawler();

        $crawler->addHtmlContent($html_content);

        $badge_nodes = $crawler->filter('#' . config('badge.prefix') . '-badge');

        if ($badge_nodes->count() === 0) {
            throw new Exception('Badge Not Found on Page');
        }

        $this->badge->status = true;
        $this->badge->save();

        //TODO: More checking Badge
        //$badge_node = $badge_nodes->first();

    }

    /**
     * The job failed to process.
     *
     * @param Exception $exception
     * @return void
     */
    public function failed(Exception $exception) {

        $this->badge->status = false;
        $this->badge->save();

    }

}
