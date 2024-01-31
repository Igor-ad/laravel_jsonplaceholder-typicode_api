<?php

declare(strict_types=1);

namespace App\Services;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection as Collect;

class ContentService
{
    /**
     * @throws GuzzleException
     */
    public function __construct(
        protected UpdateDeleteService $updateDeleteService,
        protected string              $content = '',
        protected ?Collect            $collection = null,
    )
    {
        $this->setContent();
        $this->setCollection($this->content);
    }

    public function getCollection(): ?Collect
    {
        return $this->collection;
    }

    /**
     * @throws GuzzleException
     */
    protected function setContent(): void
    {
        $this->content = DownloadService::getContent(
            (string)config('services.place_holder.json_source_url'),
            config('services.place_holder.path_to_json_source')
        );
    }

    protected function setCollection(string $jsonContent): void
    {
        $this->collection = collect(json_decode($jsonContent));
    }

    public function run(): void
    {
        $this->updateDeleteService->setExistKeys();
        $this->updateDeleteService->setContentKeys($this->getCollection());
        $this->updateDeleteService->setDeleteKeys();
        $this->updateDeleteService->dataProcessing($this->getCollection());
    }
}
