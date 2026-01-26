<?php

$router->get('/', function () use ($router) {
    return response()->json([
        'app' => 'ImovelAPI',
        'version' => '1.0.0'
    ]);
});

$router->group(['prefix'=> 'api/v1'], function () use ($router) {
    $router->get('imoveis', 'ImovelController@index');
    $router->get('imovels/{id}', 'ImovelController@show');
    $router->post('imovels', 'ImovelController@store');
    $router->put('imovels/{id}', 'ImovelController@update');
    $router->delete('imovels/{id}', 'ImovelController@destroy');
});
