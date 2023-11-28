<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\Address;
use Illuminate\Database\Eloquent\Collection;

class AddressController extends AbstractController
{
    protected function getCollection(): Collection
    {
        return Address::with('geo')->get();
    }

    public function extract(object $collect): array
    {
        return collect($collect->address)
            ->except('geo')
            ->put('user_id', $collect->id)
            ->toArray();
    }

    public function upsert(array $data = []): int
    {
        return Address::query()->upsert(
            $this->getData(),
            Address::getFillableAttributes(),
            Address::getFillableAttributes()
        );
    }

    public function restore(array $keys): int
    {
        return Address::onlyTrashed()->whereIn('user_id', $keys)->restore();
    }

    public function softDelete(array $keys): int
    {
        return Address::query()->whereIn('user_id', $keys)->delete();
    }
}
