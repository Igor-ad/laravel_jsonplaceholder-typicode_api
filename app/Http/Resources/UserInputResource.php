<?php

declare(strict_types=1);

namespace App\Http\Resources;

class UserInputResource
{
    public function toArray(object $data): array
    {
        return [
            'id' => $data->id,
            'name' => $data->name,
            'username' => $data->username,
            'email' => $data->email,
            'phone' => $data->phone,
            'website' => $data->website,
        ];
    }
}
