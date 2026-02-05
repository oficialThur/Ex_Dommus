<?php

require_once 'service/SwapiClient.php';
include_once 'views/PlanetaHtmlRenderer.php';

$action = $_GET['action'] ?? 'home';

try {
    $client = new SwapiClient();
    $renderer = new PlanetaHtmlRenderer();

    switch ($action) {
        case 'buscar':
            $id = $_GET['id'] ?? null;
            if (!$id || !is_numeric($id)) {
                throw new Exception("ID inválido para busca.");
            }
            $dadosPlaneta = $client->buscarPorId($id);
            echo $renderer->renderPlaneta($dadosPlaneta);
            break;

        case 'listar':
            $listaPlanetas = $client->listarTodos();
            echo $renderer->renderTabela($listaPlanetas);
            break;

        case 'home':
        default:
            require 'views/home.php';
            break;
    }

} catch (Exception $e) {
    $erro = $e->getMessage();
    require 'views/home.php';
}
