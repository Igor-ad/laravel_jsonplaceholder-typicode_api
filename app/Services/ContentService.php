<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\Api\ContentProcessingException;
use Illuminate\Support\Collection as Collect;
use Illuminate\Support\Facades\Cache;

class ContentService
{
    /**
     * @throws ContentProcessingException
     */
    public function __construct(
        protected DataProcessingService $processingService,
        protected ?string               $content = null,
        protected ?Collect              $collection = null,
    ) {
        $this->setContent();
        $this->setCollection($this->content);
    }

    /**
     * @throws ContentProcessingException
     */
    private function setContent(): void
    {
        $this->content = Cache::get('users');

        if (is_null($this->content)) {
            $this->content = DownloadService::getContent(
                (string)config('services.place_holder.json_source_url'),
                (string)config('services.place_holder.path_to_json_source')
            );
            Cache::set('users', $this->content, (int)config('services.place_holder.expiration'));
        }
    }

    private function setCollection(string $jsonContent): void
    {
        $this->collection = collect(json_decode($jsonContent));
    }

    /**
     * @throws ContentProcessingException
     */
    public function run(): int|ContentProcessingException
    {
        try {
            $this->processingService->contentProcessing($this->collection);
        } catch (\Exception $e) {
            throw new ContentProcessingException($e->getMessage());
        }
        return 0;
    }
}
