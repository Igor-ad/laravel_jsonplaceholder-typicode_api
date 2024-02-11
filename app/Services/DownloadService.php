<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\Api\ContentProcessingException;
use Illuminate\Support\Facades\Http;

class DownloadService
{
    /**
     * @throws ContentProcessingException
     */
    public static function getContent(string $url, string $path, string $param = ''): string
    {
        try {

            return Http::get($url . $path . $param )->throw()->body();

        } catch (\Exception $e) {

            throw new ContentProcessingException($e->getMessage());
        }
    }
}
