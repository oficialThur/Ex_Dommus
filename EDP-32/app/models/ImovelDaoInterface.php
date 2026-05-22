<?php

require_once __DIR__ . '/Imovel.php';

interface ImovelDaoInterface {
    public function findAll(): array;
    public function update(Imovel $imovel): void;
}
