<?php

spl_autoload_register(function ($nomeDaClasse) {
    $diretorios = [
        'controllers',
        'models',
        'services',
        'db'
    ];

    // Procura a classe em cada diretório
    foreach ($diretorios as $diretorio) {
        $arquivo = __DIR__ . DIRECTORY_SEPARATOR . $diretorio . DIRECTORY_SEPARATOR . $nomeDaClasse . '.php';

        if (file_exists($arquivo)) {
            require_once $arquivo;
            return;
        }
    }
});