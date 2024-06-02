<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserController extends AbstractController
{
    public function index(): ResourceCollection
    {
        return UserCollection::make(User::with('address', 'company')->get());
    }

    public function extract(object $collect): array
    {
        return collect($collect)
            ->except(['address', 'company'])
            ->toArray();
    }

    public function softDelete(array $keys): int
    {
        return User::query()->whereIn('id', $keys)->delete();
    }

    public function restore(array $keys): int
    {
        return User::onlyTrashed()->whereIn('id', $keys)->restore();
    }

    public function getWithTrashed(): Collection
    {
        return User::withTrashed()->get();
    }

    public function upsert(array $data = []): int
    {
        return User::query()->upsert($data, 'id',);
    }
}
