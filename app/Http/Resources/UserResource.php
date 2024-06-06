<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'phone' => $this->phone,
            'website' => $this->website,
            'address' => [
                'street' => $this->address->street,
                'suite' => $this->address->suite,
                'city' => $this->address->city,
                'zipcode' => $this->address->zipcode,
                'geo' => [
                    'lat' => $this->geo->lat,
                    'lng' => $this->geo->lng,
                ],
            ],
            'company' => [
                'name' => $this->company->name,
                'catchPhrase' => $this->company->catchPhrase,
                'bs' => $this->company->bs,
            ],
        ];
    }
}
