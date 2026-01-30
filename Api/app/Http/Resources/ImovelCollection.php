<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ImovelCollection extends ResourceCollection
{
    public $collects = ImovelResource::class;

    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'meta' => [
                'total' => $this->collection->count(),
                'soma_precos' => $this->collection->sum(function ($resource) {
                    return $resource->resource->preco;
                }),
                'paginacao' => [
                    'pagina_atual' => $this->currentPage(),
                    'por_pagina' => $this->perPage(),
                    'total_items' => $this->total(),
                ],
            ],
        ];
    }
}