<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\Geo;
use Illuminate\Database\Eloquent\Collection;

class GeoController extends AbstractController
{
    protected function getCollection(): Collection
    {
        return Geo::all();
    }

    public function extract(object $collect): array
    {
        return collect($collect->address->geo)
            ->put('user_id', $collect->id)->toArray();
    }

    public function upsert(array $data = []): int
    {
        return Geo::query()->upsert(
            $this->getData(),
            Geo::getFillableAttributes(),
            Geo::getFillableAttributes()
        );
    }

    public function restore(array $keys): int
    {
        return Geo::onlyTrashed()->whereIn('user_id', $keys)->restore();
    }

    public function softDelete(array $keys): int
    {
        return Geo::query()->whereIn('user_id', $keys)->delete();
    }
}
