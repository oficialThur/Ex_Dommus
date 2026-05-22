<?php

class DaoFactory {
    public static function createImovelDao(): ImovelDaoInterface {
        return new ImovelDaoPdo();
    }
}