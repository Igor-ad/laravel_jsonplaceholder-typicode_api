<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\GeoController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as Collect;

class UpdateDeleteService
{
    /**
     * @param GeoController $geoController
     * @param AddressController $addressController
     * @param CompanyController $companyController
     * @param UserController $userController
     * @param array $existKeys User IDs existing in the DB
     * @param array $deleteKeys User IDs that will be deleted from the DB
     * @param array $contentKeys User IDs that exist in the remote data source
     */
    public function __construct(
        protected GeoController     $geoController,
        protected AddressController $addressController,
        protected CompanyController $companyController,
        protected UserController    $userController,
        protected array             $existKeys = [],
        protected array             $deleteKeys = [],
        protected array             $contentKeys = [],
    )
    {
    }

    public function setExistKeys(): void
    {
        $this->existKeys = $this->getIds(
            $this->userController->getWithTrashed()
                ->except(config('services.place_holder.admin_id'))
        );
    }

    public function setContentKeys(Collect $collection): void
    {
        $this->contentKeys = $this->getIds($collection);
    }

    public function setDeleteKeys(): void
    {
        $this->deleteKeys = array_diff($this->existKeys, $this->contentKeys);
    }

    public function getIds(Collection|Collect $collection): array
    {
        return $collection->pluck('id')->toArray();
    }

    protected function getModelsControllers(): array
    {
        return [
            'user' => $this->userController,
            'company' => $this->companyController,
            'address' => $this->addressController,
            'geo' => $this->geoController,
        ];
    }

    public function dataProcessing($collection): void
    {
        foreach ($this->getModelsControllers() as $controller) {
            $controller->setData($collection);
            $controller->restore($this->deleteKeys);
            $controller->softDelete($this->deleteKeys);
            $controller->upsert();
        }
    }
}
