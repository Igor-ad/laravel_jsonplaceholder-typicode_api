<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserController extends Controller
{
    public function index(): ResourceCollection
    {
        $users = User::query()
            ->with(['address', 'company'])
            ->where('is_admin', null)
            ->get();

        return UserCollection::make($users);
    }

    public function restoreById(int $id): int
    {
        return User::onlyTrashed()->where('id', $id)->restore();
    }

    public function softDeleteNotInId(array $keys): int
    {
        return User::query()->whereNotIn('id', $keys)->delete();
    }

    public function upsert(array $data): int
    {
        return User::query()->upsert($data, 'id');
    }
}
