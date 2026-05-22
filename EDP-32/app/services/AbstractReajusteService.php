<?php
abstract class AbstractReajusteService{
    abstract protected function filtrar(ItemReajustavelInterface $item, float $percentual): bool;
    abstract protected function criarItem(array $dados): ?ItemReajustavelInterface;

    public function processar(array $itens, float $percentual): array
    {
        $itensProcessados = [];
        foreach($itens as $dados){
            $item = $this->criarItem($dados);

            if ($item instanceof ItemReajustavelInterface) {
                if ($this->filtrar($item, $percentual)) {
                    $item->reajustar($percentual);
                }
                $itensProcessados[] = $item;
            }
        }
        return $itensProcessados;
    }
}
