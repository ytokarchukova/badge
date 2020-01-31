<?php

namespace YTokarchukova\Badge\Jobs;

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

    /**
     * Create a new job instance.
     *
     * @param Badge $badge
     */
    public function __construct(Badge $badge) {

        $this->badge = $badge;

    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Exception
     */
    public function handle() {

        $client_args = array(
            'allow_redirects' => true,
            'timeout' => 90,
        );

        $client = new Client();

        $response = $client->request('GET', 'http://' . $this->badge->domain->address, $client_args);

        if ($response->getStatusCode() !== 200) {
            $this->fail(new \Exception('Getting Site Error'));
        }

        $html_content = $response->getBody()->getContents();

        $crawler = new Crawler();

        $crawler->addHtmlContent($html_content);

        $badge_nodes = $crawler->filter('#' . config('badge.prefix') . '-badge');

        if ($badge_nodes->count() === 0) {
            $this->fail(new \Exception('Badge Not Found on Page'));
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
