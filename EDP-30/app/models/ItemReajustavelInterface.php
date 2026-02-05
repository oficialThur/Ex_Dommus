<?php

interface ItemReajustavelInterface{
    public function reajustar(float $percentual): void;
    public function getPreco(): float;
    public function getPrecoOriginal(): float;
}