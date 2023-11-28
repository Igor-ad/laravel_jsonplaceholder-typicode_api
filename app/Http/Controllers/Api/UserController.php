<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserController extends AbstractController
{
    protected function getCollection(): Collection
    {
        return User::with('address', 'company')->get(User::getFillableAttributes());
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
        return User::query()->upsert(
            $this->getData(),
            User::getFillableAttributes(),
            User::getFillableAttributes()
        );
    }
}
