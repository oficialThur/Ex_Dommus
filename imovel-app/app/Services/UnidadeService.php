<?php

namespace App\Services;

use App\Contracts\ReajustePrecoInterface;
use App\Models\Imovel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UnidadeService implements ReajustePrecoInterface
{
    public function aplicarReajuste(Collection $imoveis, float $percentual): int
    {
        if ($percentual <= 0){
            throw new \InvalidArgumentException(
                'O percentual de reajuste deve ser maior que zero'
            );
        }

        $quantidadeReajustada = 0;

        DB::beginTransaction();

        try {
            foreach ($imoveis as $imovel){
                if ($imovel->disponibilidade !== 'DISPONIVEL'){
                    Log::debug("Imovel #{$imovel->id} pulado - Status: {$imovel->disponibilidade}");
                    continue;
                }

                $precoAtual = $imovel->preco;
                $reajuste = ($precoAtual * $percentual) / 100;
                $precoNovo = $precoAtual + $reajuste;

                $imovel->preco = $precoNovo;
                $imovel->save();

                $quantidadeReajustada++;
            }

            DB::commit();

            Log::info("Reajuste realizado com sucesso", [
                'total_processados' => $imoveis->count(),
                'total_reajustados' => $quantidadeReajustada,
                'percentual' => $percentual . '%'
            ]);
            return $quantidadeReajustada;
        } 
        catch (\Exception $e) {
            DB::rollBack();

            Log::error("Falha no reajuste em massa", [
                'total_processados' => $imoveis->count(),
                'total_reajustados' => $quantidadeReajustada,
                'percentual' => $percentual . '%',
                'erro' => $e->getMessage()
            ]);

            throw $e;
        }
    }

    public function calcularReajuste(float $preco, float $percentual): float
    {
        return ($preco * $percentual) / 100;
    }

    public function calcularNovoPreco(float $preco, float $percentual): float
    {
        $reajuste = $this->calcularReajuste($preco, $percentual);
        return $preco + $reajuste;
    }

    public function simularReajuste(Collection $imovel, float $percentual): array
    {
        $simulacao = [];
        
        foreach ($imovel as $item){
            if ($item->disponibilidade !== 'DISPONIVEL'){
                continue;
            }

            $precoAtual = $item->preco;
            $precoNovo = $this->calcularNovoPreco($precoAtual, $percentual);
            $diferenca = $precoNovo - $precoAtual;

            $simulacao[] = [
                'id' => $item->id,
                'descricao' => $item->descricao,
                'preco_atual' => $precoAtual,
                'preco_novo' => $precoNovo,
                'diferenca' => $diferenca,
                'percentual' => $percentual
            ];
        }
        return $simulacao;
    }    
}   