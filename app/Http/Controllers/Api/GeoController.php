<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resources\GeoCollection;
use App\Models\Geo;
use Illuminate\Http\Resources\Json\ResourceCollection;

class GeoController extends AbstractController
{
        public function index(): ResourceCollection
    {
        return GeoCollection::make(Geo::all());
    }

    public function extract(object $collect): array
    {
        return collect($collect->address->geo)
            ->put('user_id', $collect->id)->toArray();
    }

    public function upsert(array $data = []): int
    {
        return Geo::query()->upsert($data, 'user_id');
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
