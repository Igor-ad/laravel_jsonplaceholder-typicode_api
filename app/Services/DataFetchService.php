<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\Api\ContentProcessingException;
use Illuminate\Support\Facades\Http;

class DataFetchService
{
    /**
     * @throws ContentProcessingException
     */
    public function getContent(string $url, string $path, array $param = []): array
    {
        try {
            $response = Http::get($url . $path, $param);
        } catch (\Throwable $e) {
            throw new ContentProcessingException($e->getMessage());
        }
        return $response->json();
    }
}
