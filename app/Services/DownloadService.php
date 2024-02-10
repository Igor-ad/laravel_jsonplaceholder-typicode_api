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
            $response = Http::get($url . $path . $param);
        } catch (\Exception $e) {
            throw new ContentProcessingException($e->getMessage());
        }

        if ($response->status() === 200) {

            return Http::get($url . $path . $param)->body();
        }

        throw new ContentProcessingException(
            'Can not get remote content',
            $response->status()
        );
    }
}
