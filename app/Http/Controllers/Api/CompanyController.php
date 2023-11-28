<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\Company;
use Illuminate\Database\Eloquent\Collection;

class CompanyController extends AbstractController
{
    protected function getCollection(): Collection
    {
        return Company::all();
    }

    public function extract(object $collect): array
    {
        return collect($collect->company)
            ->put('user_id', $collect->id)
            ->toArray();
    }

    public function upsert(array $data = []): int
    {
        return Company::query()->upsert(
            $this->getData(),
            Company::getFillableAttributes(),
            Company::getFillableAttributes()
        );
    }

    public function restore(array $keys): int
    {
        return Company::onlyTrashed()->whereIn('user_id', $keys)->restore();
    }

    public function softDelete(array $keys): int
    {
        return Company::query()->whereIn('user_id', $keys)->delete();
    }
}
