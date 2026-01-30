<?php

$router->get('/', function () use ($router) {
    return response()->json([
        'app' => 'ImovelAPI',
        'version' => '1.0.0'
    ]);
});

$router->group(['prefix' => 'api/v1', 'middleware' => 'auth.basic'], function () use ($router) {
    $router->get('imoveis', 'ImovelController@index');
    $router->post('imoveis', 'ImovelController@store');
    
    $router->post('imoveis/reajuste', 'ImovelController@reajusteEmMassa');
    $router->get('imoveis/exportar', 'ImovelController@exportarCsv');

    $router->get('imoveis/{id}', 'ImovelController@show');
    $router->put('imoveis/{id}', 'ImovelController@update');
    $router->delete('imoveis/{id}', 'ImovelController@destroy');
});

$router->get('/teste-observer', function (){
    try {
        $imovel = \App\Models\Imovel::create([
            'descricao' => 'apartamento teste',
            'preco' => 300000,
            'disponibilidade' => 'DISPONIVEL'
        ]);
        echo "Criado: #{$imovel->id}<br>";

        $imovel->preco = 350000;
        $imovel->save();    
        echo "Preço alterado: #{$imovel->preco}<br>";

        $imovel->disponibilidade = 'VENDIDO';
        $imovel->save();
        echo "Status alterado: #{$imovel->disponibilidade}<br>";

        try {
            $imovel->preco = 400000;
            $imovel->save();
            echo "ERRO: Permitiu alterar preço de imóvel VENDIDO!<br>";
        } catch (\Exception $e) {
            echo "CORRETO: Bloqueou alteração - " . $e->getMessage() . "<br>";
        }

        $imovel->disponibilidade = 'DISPONIVEL';
        $imovel->save();
        $imovel->softDelete();
        echo "Excluído com sucesso (soft delete)<br>";
    } catch (\Exception $e){
        echo "ERRO: " . $e->getMessage();
    }
});
