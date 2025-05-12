<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Console\Commands\Content;
use App\Exceptions\Api\ContentProcessingException;
use Illuminate\Http\JsonResponse;

class ContentController
{
    /**
     * @throws ContentProcessingException
     */
    public function __invoke(Content $content): JsonResponse
    {
        return response()->json([
            'success' => $content->handle() === 0,
            'message' => 'Content from a remote source processed successfully.',
        ]);
    }
}
