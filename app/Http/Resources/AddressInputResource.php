<?php

declare(strict_types=1);

namespace App\Http\Resources;

class AddressInputResource
{
    public function toArray(object $data): array
    {
        return [
            'user_id' => $data->id,
            'street' => $data->address->street,
            'suite' => $data->address->suite,
            'city' => $data->address->city,
            'zipcode' => $data->address->zipcode,
        ];
    }
}
