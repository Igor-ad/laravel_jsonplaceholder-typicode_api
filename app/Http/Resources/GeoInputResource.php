<?php

declare(strict_types=1);

namespace App\Http\Resources;

class GeoInputResource
{
    public function toArray(object $data): array
    {
        return [
            'user_id' => $data->id,
            'lat' => $data->address->geo->lat,
            'lng' => $data->address->geo->lng,
        ];
    }
}
