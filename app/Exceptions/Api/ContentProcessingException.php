<?php

declare(strict_types=1);

namespace App\Exceptions\Api;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContentProcessingException extends Exception
{
    public function render(Request $request): JsonResponse
    {
        return response()->json(
            data: [
                'success' => false,
                'error' => $this->getMessage(),
            ],
            options: JSON_PRETTY_PRINT,
        );
    }
}
