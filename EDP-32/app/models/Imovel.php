<?php

class Imovel implements ItemReajustavelInterface{
    use ReajusteTrait;

    private int $id;
    private string $descricao;
    private float $precoOriginal;
    private float $preco;
    private string $disponibilidade;
    public const STATUS_DISPONIVEL = 'disponivel';
    public const STATUS_INDISPONIVEL = 'indisponivel';

    public function __construct(int $id, string $descricao, float $preco, string $disponibilidade)
    {
        $this->id = $id;
        $this->descricao = $descricao;
        $this->precoOriginal = $preco;
        $this->preco = $preco;
        $this->disponibilidade = $disponibilidade;
    }

    // get e set id
    public function getId(): int
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    // get,set e ToString descricao

    public function getDescricao(): string
    {
        return $this->descricao;
    }

    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    public function __toString(): string
    {
        return $this->descricao;
    }

    // get e set disponibilidade

    public function getDisponibilidade(): string
    {
        return $this->disponibilidade;
    }

    public function setDisponibilidade($disponibilidade)
    {
        $this->disponibilidade = $disponibilidade;
    }


    public function getPreco(): float
    {
        return $this->preco;
    }

    public function getPrecoOriginal(): float
    {
        return $this->precoOriginal;
    }

    public function podeReceberReajuste(float $percentual): bool
    {
        // Valida se o percentual é positivo
        if ($percentual <= 0) {
            return false;
        }
        if ($this->disponibilidade !== self::STATUS_DISPONIVEL) {
            return false;
        }
        return true;
    }

    public function reajustar(float $percentual): void
    {
        if (!$this->podeReceberReajuste($percentual)) {
            return;
        }
        $this->aplicarReajuste($percentual);
    }
    
}
