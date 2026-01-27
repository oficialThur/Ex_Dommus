<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

interface ReajustePrecoInterface
{
    public function aplicarReajuste(Collection $imoveis, float $percentual): int;
}
