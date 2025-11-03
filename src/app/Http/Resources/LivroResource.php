<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
// use NumberFormatter;

class LivroResource extends JsonResource
{
    public function toArray($request): array
    {
        $valor = $this->Valor ?? 0;

        // formata moeda pt_BR
        // $formatter = new \NumberFormatter('pt_BR', \NumberFormatter::CURRENCY);
        // $valorFormatado = $formatter->format($valor);

        return [
            'id' => $this->Codl,
            'titulo' => $this->Titulo,
            'editora' => $this->Editora,
            'edicao' => $this->Edicao,
            'ano_publicacao' => $this->AnoPublicacao,
            'valor' => (float) $valor,
            'valor_formatado' => $valorFormatado,
            'autores' => $this->whenLoaded('autores', $this->autores->map(function($a){
                return [
                    'id' => $a->CodAu,
                    'nome' => $a->Nome,
                ];
            })),
            'assuntos' => $this->whenLoaded('assuntos', $this->assuntos->map(function($s){
                return [
                    'id' => $s->CodAs,
                    'descricao' => $s->Descricao,
                ];
            })),
        ];
    }
}
