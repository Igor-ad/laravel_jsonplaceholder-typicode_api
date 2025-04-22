<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyIndexCollection;
use App\Http\Resources\CompanyInputResource;
use App\Models\Company;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CompanyController extends Controller
{
    public function index(): ResourceCollection
    {
        return CompanyIndexCollection::make(
            Company::with('user:id,name,username,email')
                ->get()
        );
    }

    public function fromCollect(object $collect): Company
    {
        return Company::updateOrCreate((new CompanyInputResource())->toArray($collect));
    }

    public function restoreById(int $id): int
    {
        return Company::onlyTrashed()->where('user_id', $id)->restore();
    }

    public function softDeleteNotInId(array $keys): int
    {
        return Company::query()->whereNotIn('user_id', $keys)->delete();
    }
}
