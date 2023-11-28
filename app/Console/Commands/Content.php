<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\ContentService;
use Illuminate\Console\Command;

class Content extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:content';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Content processing from remote source';

    /**
     * Execute the console command.
     */
    public function handle(ContentService $content)
    {
        $content->run();
        info('OK, Cron is working!'); // Cron writes test line in the "storage/logs/laravel.log"

        return 0;
    }
}
