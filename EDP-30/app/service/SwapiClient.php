<?php 

class SwapiClient {
    private $baseUrl = "https://swapi.info/api/planets";

    private function request($urlApi){
        $opcoes = [
           "ssl" => [
               "verify_peer" => false,
               "verify_peer_name" => false,
           ],
       ];
       $contexto = stream_context_create($opcoes);
   
       $resposta = @file_get_contents($urlApi, false, $contexto);

       if ($resposta === false) {
           throw new Exception("Erro ao conectar com a API SWAPI.");
       }

       return json_decode($resposta, true);
    }

    public function buscarPorId($id) {
        return $this->request($this->baseUrl . '/' . $id);
    }

    public function listarTodos() {
        return $this->request($this->baseUrl);
    }
}