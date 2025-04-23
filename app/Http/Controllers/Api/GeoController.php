<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GeoIndexCollection;
use App\Models\Geo;
use Illuminate\Http\Resources\Json\ResourceCollection;

class GeoController extends Controller
{
    public function index(): ResourceCollection
    {
        return GeoIndexCollection::make(
            Geo::with('user:id,name,username,email')
                ->get()
        );
    }

    public function restore(array $keys): int
    {
        return Geo::onlyTrashed()->whereIn('user_id', $keys)->restore();
    }

    public function softDeleteNotInId(array $keys): int
    {
        return Geo::query()->whereNotIn('user_id', $keys)->delete();
    }

    public function upsert(array $data): int
    {
        return Geo::query()->upsert($data, 'user_id');
    }
}
