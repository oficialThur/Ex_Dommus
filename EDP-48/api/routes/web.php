<?php

$router->get('/', function () use ($router) {
    return new \Illuminate\Http\JsonResponse([
        'app' => 'ImovelAPI',
        'version' => '1.0.0'
    ]);
});

$router->group(['prefix' => 'api/v1'], function () use ($router) {
    $router->get('imoveis', 'ImovelController@index');
    $router->post('imoveis', 'ImovelController@store');
    
    $router->post('imoveis/reajuste', 'ImovelController@reajusteEmMassa');
    $router->get('imoveis/exportar', 'ImovelController@exportarCsv');

    $router->get('imoveis/{id}', 'ImovelController@show');
    $router->put('imoveis/{id}', 'ImovelController@update');
    $router->delete('imoveis/{id}', 'ImovelController@destroy');
});

