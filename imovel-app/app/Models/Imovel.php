<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class Imovel extends Model
{
    protected $table = 'imovels';

    protected $fillable = [
        'descricao', 
        'preco', 
        'disponibilidade', 
        'ativo'
    ];

    protected $hidden = [
        'ativo', 
        'created_at', 
        'updated_at'
    ];

    protected $casts = [
        'preco' => 'decimal:2',
        'ativo' => 'boolean'
    ];

    public function scopeAtivos(Builder $query): Builder
    {
        return $query->where('ativo', true);
    }

    public function softDelete(): bool
    {
        $this->ativo = false;
        return true;    
    }

    public function restore(): bool
    {
        return $this->ativo === false;
    }

    protected static function booted()
    {
        static::addGlobalScope('ativo', function (Builder $builder){
            $builder->where('ativo', true);
        });
    }
}
