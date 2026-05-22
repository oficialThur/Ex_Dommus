<?php

require_once __DIR__ . '/../models/ImovelDaoInterface.php';
require_once __DIR__ . '/Connection.php';
require_once __DIR__ . '/../models/Imovel.php';

class ImovelDaoPdo implements ImovelDaoInterface {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = Connection::getInstance()->getConnection();
    }

    public function findAll(): array {
        $stmt = $this->pdo->query("SELECT * FROM imoveis");
        
        $dadosImoveis = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $imoveisObjetos = [];

        foreach ($dadosImoveis as $dado) {
            $imoveisObjetos[] = new Imovel(
                (int)$dado['id'],
                $dado['descricao'],
                (float)$dado['preco'],
                $dado['disponibilidade'] 
            );
        }

        return $imoveisObjetos;
    }

    public function update(Imovel $imovel): void {
        $sql = "UPDATE imoveis SET preco = :preco WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':preco', $imovel->getPreco());
        $stmt->bindValue(':id', $imovel->getId());

        $stmt->execute();
    }
}