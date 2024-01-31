<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Services\ContentService;
use Illuminate\Http\JsonResponse;

class ContentController
{
    public function __invoke(ContentService $content): JsonResponse
    {
        $content->run();

        return response()->json([
            'message' => 'Processing of content from a remote source was successful',
        ], 200,[],JSON_PRETTY_PRINT
        );
    }
}
