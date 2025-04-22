<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AddressIndexCollection;
use App\Http\Resources\AddressInoutResource;
use App\Models\Address;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AddressController extends Controller
{
    public function index(): ResourceCollection
    {
        return AddressIndexCollection::make(
            Address::with(['geo', 'user:id,name,username,email'])
                ->get()
        );
    }

    public function fromCollect(object $collect): Address
    {
        return Address::updateOrCreate((new AddressInoutResource())->toArray($collect));
    }
    public function restoreById(int $id): int
    {
        return Address::onlyTrashed()->where('user_id', $id)->restore();
    }

    public function softDeleteNotInId(array $keys): int
    {
        return Address::query()->whereNotIn('user_id', $keys)->delete();
    }
}
