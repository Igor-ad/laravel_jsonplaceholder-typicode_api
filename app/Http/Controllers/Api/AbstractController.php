<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection as Collect;

abstract class AbstractController extends Controller
{
    abstract public function index(): ResourceCollection;

    /**
     *  Extract collection from remote source JSON data
     */
    abstract protected function extract(object $collect): array;

    /**
     *  Restore collection instances that have been soft deleted
     */
    abstract public function restore(array $keys): int;

    /**
     *  Update or insert new collection instances into the DB
     */
    abstract public function upsert(array $data): int;

    /**
     *  Mass soft delete models
     */
    abstract public function softDelete(array $keys): int;

    /**
     *  Extract model array from collection
     */
    public function toArray(Collect $collection): array
    {
        return $collection->map(fn(object $collect) => $this->extract($collect))->toArray();
    }
}
