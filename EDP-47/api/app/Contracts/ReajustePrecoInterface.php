<?php

namespace App\Contracts;

interface ReajustePrecoInterface
{
    public function aplicarReajuste($imoveis, float $percentual): int;
}