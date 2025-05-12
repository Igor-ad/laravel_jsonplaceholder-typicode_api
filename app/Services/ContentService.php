<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\Api\ContentProcessingException;
use Illuminate\Support\Collection as Collect;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class ContentService
{
    /**
     * @throws ContentProcessingException
     */
    public function __construct(
        protected DataFetchService      $dataFetchService,
        protected ?string               $content = null,
        protected ?Collect              $collection = null,
    ) {
        $this->setContent();
        $this->setCollection($this->content);
    }

    /**
     * @return Collect|null
     */
    public function getCollection(): ?Collect
    {
        return $this->collection;
    }

    /**
     * @throws ContentProcessingException
     */
    private function setContent(): void
    {
        $this->content = Cache::get('users');

        if (is_null($this->content)) {
            $data = $this->dataFetchService->getContent(
                (string)config('services.place_holder.json_source_url'),
                (string)config('services.place_holder.path_to_json_source')
            );
            $data = $this->iterateData($data);
            $this->content = collect($data)->toJson();

            Cache::set('users', $this->content, (int)config('services.place_holder.expiration'));
        }
    }

    /**
     * @throws ContentProcessingException
     */
    private function iterateData(array $data): array
    {
        foreach ($data as $item) {
            $this->validateDataItem($item);
        }
        return $data;
    }

    /**
     * @throws ContentProcessingException
     */
    private function validateDataItem(array $item): void
    {
        $validator = Validator::make($item, [
            'id' => 'required|int',
            'name' => 'required|string',
            'username' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'website' => 'required|string',
            'address' => 'required|array',
            'address.street' => 'required|string',
            'address.suite' => 'required|string',
            'address.city' => 'required|string',
            'address.zipcode' => 'required|string',
            'address.geo' => 'required|array',
            'address.geo.lat' => 'required|numeric|between:-90,90',
            'address.geo.lng' => 'required|numeric|between:-180,180',
            'company' => 'required|array',
            'company.name' => 'required|string',
            'company.catchPhrase' => 'required|string',
            'company.bs' => 'required|string',
        ]);

        if ($validator->fails()) {
            throw new ContentProcessingException(
                sprintf('Invalid user data. Errors: %s', $validator->errors())
            );
        }
    }

    private function setCollection(string $jsonContent): void
    {
        $this->collection = collect(json_decode($jsonContent));
    }
}
