<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\GeoController;
use App\Http\Controllers\Api\UserController;
use App\Http\Resources\AddressInputResource;
use App\Http\Resources\CompanyInputResource;
use App\Http\Resources\GeoInputResource;
use App\Http\Resources\UserInputResource;
use Illuminate\Support\Collection as Collect;

class DataProcessingService
{
    public function __construct(
        private GeoController     $geoController,
        private AddressController $addressController,
        private CompanyController $companyController,
        private UserController    $userController,
        private array             $collectKeys = [],
        private array             $users = [],
        private array             $companies = [],
        private array             $addresses = [],
        private array             $geo = [],
    ) {
    }

    public function contentProcessing(Collect $collection): void
    {
        $collection->map(
            function ($data): void {
                $this->collectKeys[] = (int)$data->id;
                $this->users[] = (new UserInputResource())->toArray($data);
                $this->companies[] = (new CompanyInputResource())->toArray($data);
                $this->addresses[] = (new AddressInputResource())->toArray($data);
                $this->geo[] = (new GeoInputResource())->toArray($data);
            }
        );
        $this->restore($this->collectKeys);
        $this->upsert();
        $this->collectKeys[] = (int)config('services.place_holder.admin_id');
        $this->softDelete($this->collectKeys);
    }

    private function restore(array $keys): void
    {
        $this->userController->restore($keys);
        $this->companyController->restore($keys);
        $this->addressController->restore($keys);
        $this->geoController->restore($keys);
    }

    private function softDelete(array $keys): void
    {
        $this->userController->softDeleteNotInId($keys);
        $this->companyController->softDeleteNotInId($keys);
        $this->addressController->softDeleteNotInId($keys);
        $this->geoController->softDeleteNotInId($keys);
    }

    private function upsert(): void
    {
        $this->userController->upsert($this->users);
        $this->companyController->upsert($this->companies);
        $this->addressController->upsert($this->addresses);
        $this->geoController->upsert($this->geo);
    }
}
