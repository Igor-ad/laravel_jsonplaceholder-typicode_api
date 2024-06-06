<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resources\CompanyIndexCollection;
use App\Models\Company;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CompanyController extends AbstractController
{
    public function index(): ResourceCollection
    {
        return CompanyIndexCollection::make(
            Company::with('user:id,name,username,email')
                ->get()
        );
    }

    public function extract(object $collect): array
    {
        return collect($collect->company)
            ->put('user_id', $collect->id)
            ->toArray();
    }

    public function upsert(array $data = []): int
    {
        return Company::query()->upsert($data, 'user_id');
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
