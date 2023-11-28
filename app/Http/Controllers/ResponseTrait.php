<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

trait ResponseTrait
{
    public function collectionResponse(array|Collection $collection): JsonResponse
    {
        return response()->json($collection,
            status: Response::HTTP_OK,
            options: JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT,
        );
    }
}
