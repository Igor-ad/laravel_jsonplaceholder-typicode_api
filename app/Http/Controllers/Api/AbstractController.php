<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection as Collect;

abstract class AbstractController extends Controller
{
    use ResponseTrait;

    /**
     *  Models Array from remote API request for local upsert operations
     */
    private array $data = [];

    /**
     *  Get collection from DB
     */
    abstract protected function getCollection(): Collection;

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

    public function setData(Collect $collection): void
    {
        $this->data = $this->toArray($collection);
    }

    public function getData(): array
    {
        return $this->data;
    }

    /**
     *  Model index, JSON response to an API request from the endpoint
     */
    public function index(): JsonResponse
    {
        return $this->collectionResponse($this->getCollection());
    }

    /**
     *  Extract model array from collection
     */
    protected function toArray(Collect $collection): array
    {
        return $collection->map(function (object $collect) {
            return $this->extract($collect);
        })->toArray();
    }
}
