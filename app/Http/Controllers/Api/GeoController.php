<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GeoIndexCollection;
use App\Http\Resources\GeoInputResource;
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

    public function fromCollect(object $collect): Geo
    {
        return Geo::updateOrCreate((new GeoInputResource())->toArray($collect));
    }

    public function restoreById(int $id): int
    {
        return Geo::onlyTrashed()->where('user_id', $id)->restore();
    }

    public function softDeleteNotInId(array $keys): int
    {
        return Geo::query()->whereNotIn('user_id', $keys)->delete();
    }
}
