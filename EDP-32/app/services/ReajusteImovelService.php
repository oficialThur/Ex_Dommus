<?php

class ReajusteImovelService extends AbstractReajusteService{
    
    private ImovelDaoInterface $dao;

    public function __construct(ImovelDaoInterface $dao)
    {
        $this->dao = $dao;
    }

    private static float $precoMinimo = 50000.0;
    
    protected function filtrar(ItemReajustavelInterface $item, float $percentual): bool
    {
        if (!$item instanceof Imovel) {
            return false;
        }
        
        return $item->podeReceberReajuste($percentual) && self::validarPrecoMinimo($item);
    }
    
    public function processar(array $itens, float $percentual): array
    {
        $imoveis = $this->dao->findAll();

        foreach ($imoveis as $imovel) {
            if ($this->filtrar($imovel, $percentual)) {
                $imovel->reajustar($percentual);
                $this->dao->update($imovel);
            }
        }
        return $imoveis;
    }

    private static function validarPrecoMinimo(Imovel $imovel): bool
    {
        return $imovel->getPreco() >= self::$precoMinimo;
    }

    protected function criarItem(array $dados): ?ItemReajustavelInterface
    {
        if (isset($dados['id'], $dados['descricao'], $dados['preco'], $dados['disponibilidade'])) {
            return new Imovel(
                (int) $dados['id'],
                trim($dados['descricao']),
                (float) $dados['preco'],
                trim($dados['disponibilidade'])
            );
        }
        return null;
    }
}
