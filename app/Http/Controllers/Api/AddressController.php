<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AddressIndexCollection;
use App\Models\Address;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AddressController extends Controller
{
    public function index(): ResourceCollection
    {
        return AddressIndexCollection::make(
            Address::with(['geo', 'user'])
                ->get()
        );
    }

    public function restore(array $keys): int
    {
        return Address::onlyTrashed()->whereIn('user_id', $keys)->restore();
    }

    public function softDeleteNotInId(array $keys): int
    {
        return Address::query()->whereNotIn('user_id', $keys)->delete();
    }

    public function upsert(array $data): int
    {
        return Address::query()->upsert($data, 'user_id');
    }
}
