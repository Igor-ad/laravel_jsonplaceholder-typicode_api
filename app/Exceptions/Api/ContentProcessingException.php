<?php

declare(strict_types=1);

namespace App\Exceptions\Api;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContentProcessingException extends Exception
{
    public function __construct(string $message, protected int|null $statusCode = null)
    {
        parent::__construct($message);
    }

    public function render(Request $request): JsonResponse
    {
        return response()->json(
            data: [
                'error' => $this->getMessage(),
                'remote content server returned status code: ' => $this->statusCode,
            ],
            options: JSON_PRETTY_PRINT,
        );
    }
}
