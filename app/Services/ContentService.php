<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\Api\ContentProcessingException;
use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\GeoController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Collection as Collect;
use Illuminate\Support\Facades\Cache;

class ContentService
{
    /**
     * @throws ContentProcessingException
     */
    public function __construct(
        protected GeoController     $geoController,
        protected AddressController $addressController,
        protected CompanyController $companyController,
        protected UserController    $userController,
        protected ?string           $content = null,
        protected ?Collect          $collection = null,
        protected array             $existKeys = [],
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
            $this->contentProcessing();
        } catch (\Exception $e) {

            throw new ContentProcessingException($e->getMessage());
        }
        return 0;
    }

    private function contentProcessing(): void
    {
        $this->collection->map(
            function ($data) {
                $this->existKeys[] = $data->id;
                $this->restore($data);
                $this->createModels($data);
            }
        );

        $this->existKeys[] = config('services.place_holder.admin_id');
        $this->softDelete();
    }

    private function createModels(object $data): void
    {
        $this->userController->fromCollect($data);
        $this->companyController->fromCollect($data);
        $this->addressController->fromCollect($data);
        $this->geoController->fromCollect($data);
    }

    private function restore(object $data): void
    {
        $this->userController->restoreById($data->id);
        $this->companyController->restoreById($data->id);
        $this->addressController->restoreById($data->id);
        $this->geoController->restoreById($data->id);
    }

    private function softDelete(): void
    {
        $this->userController->softDeleteNotInId($this->existKeys);
        $this->companyController->softDeleteNotInId($this->existKeys);
        $this->addressController->softDeleteNotInId($this->existKeys);
        $this->geoController->softDeleteNotInId($this->existKeys);
    }
}
