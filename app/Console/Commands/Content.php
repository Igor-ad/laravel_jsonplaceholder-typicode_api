<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Exceptions\Api\ContentProcessingException;
use App\Services\ContentService;
use App\Services\DataProcessingService;
use Illuminate\Console\Command;

class Content extends Command
{
    protected $signature = 'app:content';

    protected $description = 'Content processing from remote source';

    public function __construct(
        protected ContentService $contentService,
        protected DataProcessingService $processingService,
    ) {
        parent::__construct();
    }

    /**
     * @throws ContentProcessingException
     */
    public function handle(): int
    {
        try {
            $collection = $this->contentService->getCollection();
            $this->processingService->contentProcessing($collection);
        } catch (\Throwable $e) {
            throw new ContentProcessingException($e->getMessage());
        }

        if (config('app.env') !== 'production') {
            // Cron writes test line in the "storage/logs/laravel.log"
            info('OK, Cron is working!');
        }

        return 0;
    }
}
