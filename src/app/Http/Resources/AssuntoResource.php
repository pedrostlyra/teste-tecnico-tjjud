<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AssuntoResource extends JsonResource
{
    public function toArray($request): array
    {

        return [
            'id' => $this->CodAs,
            'descricao' => $this->Descricao,
            'livros' => $this->whenLoaded('livros', $this->livros->map(function($a){
                return [
                    'id' => $a->Codl,
                    'titulo' => $a->Titulo,
                ];
            })),
        ];
    }
}
