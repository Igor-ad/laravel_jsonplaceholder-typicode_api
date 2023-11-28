<?php

declare(strict_types=1);

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class DownloadService
{
    /**
     * @throws GuzzleException
     */
    public static function getUri(string $uri): string
    {
        $client = new Client();
        $content = $client->get($uri);

        return (string)($content->getBody());
    }

    /**
     * @throws GuzzleException
     */
    public static function getContent(string $url, string $path, string $param = ''): string
    {
        return self::getUri($url . $path . $param);
    }
}
