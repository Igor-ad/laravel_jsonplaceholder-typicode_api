<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyIndexResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'user_id' => $this->user_id,
            'name' => $this->name,
            'catchPhrase' => $this->catchPhrase,
            'bs' => $this->bs,
            'user' => $this->user,
        ];
    }
}
