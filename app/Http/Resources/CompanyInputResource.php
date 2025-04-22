<?php

declare(strict_types=1);

namespace App\Http\Resources;

class CompanyInputResource
{
    public function toArray(object $data): array
    {
        return [
            'user_id' => $data->id,
            'name' => $data->company->name,
            'catchPhrase' => $data->company->catchPhrase,
            'bs' => $data->company->bs,
        ];
    }
}
