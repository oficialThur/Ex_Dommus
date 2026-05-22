<?php

trait ReajusteTrait{
    protected function aplicarReajuste(float $percentual): void
    {
        $this->preco += $this->precoOriginal * ($percentual / 100);
    }
}