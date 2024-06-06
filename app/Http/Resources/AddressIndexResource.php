<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressIndexResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'user_id' => $this->user_id,
            'street' => $this->street,
            'suite' => $this->suite,
            'city' => $this->city,
            'zipcode' => $this->zipcode,
            'geo' => [
                'lat' => $this->geo->lat,
                'lng' => $this->geo->lng,
            ],
            'user' => $this->user,
        ];
    }
}
