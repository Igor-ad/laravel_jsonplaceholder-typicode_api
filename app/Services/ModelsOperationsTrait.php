<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Collection as Collect;

trait ModelsOperationsTrait
{
    public function setData(Collect $collection): void
    {
        $this->userController->setData($collection);
        $this->companyController->setData($collection);
        $this->addressController->setData($collection);
        $this->geoController->setData($collection);
    }

    public function restore(array $contentKeys): void
    {
        $this->userController->restore($contentKeys);
        $this->companyController->restore($contentKeys);
        $this->addressController->restore($contentKeys);
        $this->geoController->restore($contentKeys);
    }

    protected function softDelete(array $deleteKeys): void
    {
        $this->userController->softDelete($deleteKeys);
        $this->companyController->softDelete($deleteKeys);
        $this->addressController->softDelete($deleteKeys);
        $this->geoController->softDelete($deleteKeys);
    }

    public function upsert(): void
    {
        $this->userController->upsert();
        $this->companyController->upsert();
        $this->addressController->upsert();
        $this->geoController->upsert();
    }
}
