<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyIndexCollection;
use App\Models\Company;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CompanyController extends Controller
{
    public function index(): ResourceCollection
    {
        return CompanyIndexCollection::make(
            Company::with('user')
                ->get()
        );
    }

    public function restore(array $keys): int
    {
        return Company::onlyTrashed()->whereIn('user_id', $keys)->restore();
    }

    public function softDeleteNotInId(array $keys): int
    {
        return Company::query()->whereNotIn('user_id', $keys)->delete();
    }

    public function upsert(array $data): int
    {
        return Company::query()->upsert($data, 'user_id');
    }
}
