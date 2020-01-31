<?php

namespace YTokarchukova\Badge\Console\Commands;

use YTokarchukova\Badge\Models\Badge;
use YTokarchukova\Badge\Jobs\CheckBadge;
use Illuminate\Console\Command;

class BadgesToQueue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'badge:badgesToQueue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add Badges to Re-verification';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle() {

        $this->info('Starting Adding Badges to Re-verification Queue...');

        $badges = Badge::all();

        foreach ($badges as $badge) {
            CheckBadge::dispatch($badge);
        }

        $this->info('Starting Adding Badges to Re-verification Queue Finished... OK!');

    }
}
