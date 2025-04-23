<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Exceptions\Api\ContentProcessingException;
use App\Services\ContentService;
use Illuminate\Http\JsonResponse;

class ContentController
{
    /**
     * @throws ContentProcessingException
     */
    public function __invoke(ContentService $content): JsonResponse
    {

        return response()->json([
            'success' => $content->run() === 0,
            'message' => 'Content from a remote source processed successfully.',
        ]);
    }
}
