<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Imovel extends Model
{
    protected $table = 'imoveis';

    protected $fillable = [
        'descricao',
        'preco',
        'disponibilidade',
        'ativo'
    ];

    protected $casts = [
        'preco' => 'float',
        'ativo' => 'boolean',
    ];
}