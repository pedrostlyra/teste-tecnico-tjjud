<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AutorResource extends JsonResource
{
    public function toArray($request): array
    {

        return [
            'id' => $this->CodAu,
            'nome' => $this->Nome,
        ];
    }
}
