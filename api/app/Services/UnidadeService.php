<?php

namespace App\Services;

use App\Contracts\ReajustePrecoInterface;

class UnidadeService implements ReajustePrecoInterface
{
    public function aplicarReajuste($imoveis, float $percentual): int
    {
        $count = 0;
        foreach ($imoveis as $imovel) {

            if ($imovel->disponibilidade === 'DISPONIVEL') {
                $imovel->preco = $imovel->preco * (1 + ($percentual / 100));
                $imovel->save();
                $count++;
            }
        }
        return $count;
    }
}