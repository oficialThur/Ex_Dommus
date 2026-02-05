<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ImovelResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'descricao' => $this->descricao,
            'preco' => (float) $this->preco,
            'disponibilidade' => $this->disponibilidade,
            'ativo' => (bool) $this->ativo,
            'created_at' => $this->created_at->toIso8601String(),
        ];
    }
}