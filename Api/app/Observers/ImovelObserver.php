<?php

namespace App\Observers;  

use App\Models\Imovel;  
use Illuminate\Support\Facades\Log;

class ImovelObserver
{

     public function creating(Imovel $imovel): void
    {
        if (!isset($imovel->ativo)) {
            $imovel->ativo = true;
        }

        if ($imovel->descricao) {
            $imovel->descricao = ucfirst(trim($imovel->descricao));
        }

        if (!isset($imovel->disponibilidade)) {
            $imovel->disponibilidade = 'DISPONIVEL';
        }

        Log::info(" Preparando criação do imóvel", [
            'descricao' => $imovel->descricao,
            'preco' => number_format($imovel->preco, 2, ',', '.'),
            'disponibilidade' => $imovel->disponibilidade
        ]);
    }

    public function created(Imovel $imovel): void
    {
        Log::info("Novo imóvel cadastrado no sistema!", [
            'id' => $imovel->id,
            'descricao' => $imovel->descricao,
            'preco' => number_format($imovel->preco, 2, ',', '.'),
            'disponibilidade' => $imovel->disponibilidade,
            'data_cadastro' => $imovel->created_at->format('d/m/Y H:i:s')
        ]);

        Log::info("Auditoria: Imóvel criado", [
            'id' => $imovel->id,
            'dados_completos' => [
                'descricao' => $imovel->descricao,
                'preco' => $imovel->preco,
                'disponibilidade' => $imovel->disponibilidade,
                'ativo' => $imovel->ativo
            ],
            'usuario' => 'sistema',
            'ip' => request()->ip() ?? 'N/A'
        ]);

        if ($imovel->preco >= 1000000) {
            Log::warning("Imóvel de ALTO VALOR cadastrado!", [
                'id' => $imovel->id,
                'preco' => 'R$ ' . number_format($imovel->preco, 2, ',', '.'),
                'descricao' => $imovel->descricao
            ]);
        }

        $totalImoveis = \App\Models\Imovel::ativos()->count();
        $totalDisponiveis = \App\Models\Imovel::ativos()
            ->where('disponibilidade', 'DISPONIVEL')
            ->count();
        
        Log::info("Estatísticas atualizadas", [
            'total_imoveis_ativos' => $totalImoveis,
            'total_disponiveis' => $totalDisponiveis,
            'total_vendidos' => $totalImoveis - $totalDisponiveis
        ]);
    }

    public function updating(Imovel $imovel): bool
    {
        if ($imovel->isDirty('preco')) {
            if ($imovel->disponibilidade !== 'DISPONIVEL') {
                Log::warning("Tentativa de alterar preço de imóvel não disponível", [
                    'id' => $imovel->id,
                    'disponibilidade' => $imovel->disponibilidade,
                    'preco_atual' => $imovel->getOriginal('preco'),
                    'preco_tentado' => $imovel->preco
                ]);

                throw new \DomainException(
                    'Não é permitido alterar o preço de um imóvel que não esteja DISPONÍVEL. ' .
                    'Status atual: ' . $imovel->disponibilidade
                );
            }
        }

        // Regra para Soft Delete Manual (alteração do campo ativo para false)
        if ($imovel->isDirty('ativo') && $imovel->ativo === false) {
            if ($imovel->disponibilidade !== 'DISPONIVEL') {
                Log::warning("Tentativa de exclusão (soft delete) de imóvel não disponível", [
                    'id' => $imovel->id,
                    'disponibilidade' => $imovel->disponibilidade
                ]);

                throw new \DomainException(
                    'Não é permitido excluir um imóvel que não esteja DISPONÍVEL. Status atual: ' . $imovel->disponibilidade
                );
            }
        }

        return true;
    }


    public function updated(Imovel $imovel): void
    {
        if ($imovel->wasChanged('preco')) {
            $precoAntigo = $imovel->getOriginal('preco');
            $precoAtual = $imovel->preco;
            $diferenca = $precoAtual - $precoAntigo;
            $percentual = (($diferenca / $precoAntigo) * 100);

            Log::info("Preço do imóvel #{$imovel->id} foi alterado", [
                'preco_anterior' => number_format($precoAntigo, 2, ',', '.'),
                'preco_novo' => number_format($precoAtual, 2, ',', '.'),
                'diferenca' => number_format($diferenca, 2, ',', '.'),
                'percentual' => round($percentual, 2) . '%'   
            ]);
        }

        if ($imovel->wasChanged('descricao')) {
            $descricaoAntiga = $imovel->getOriginal('descricao');
            $descricaoNova = $imovel->descricao;
            
            Log::info("Descrição do imóvel #{$imovel->id} foi alterada", [
                'descricao_anterior' => $descricaoAntiga,
                'descricao_nova' => $descricaoNova
            ]);
        }

        if ($imovel->wasChanged('disponibilidade')) {
            $dispAnterior = $imovel->getOriginal('disponibilidade');
            $dispNova = $imovel->disponibilidade;
            
            Log::warning("Disponibilidade do imóvel #{$imovel->id} foi alterada", [
                'status_anterior' => $dispAnterior,
                'status_novo' => $dispNova
            ]);
            
            if ($dispAnterior === 'DISPONIVEL' && $dispNova === 'VENDIDO') {
                Log::info("Imóvel #{$imovel->id} foi VENDIDO!", [
                    'descricao' => $imovel->descricao,
                    'preco_venda' => number_format($imovel->preco, 2, ',', '.')
                ]);
                
            }
            
            if ($dispAnterior === 'VENDIDO' && $dispNova === 'DISPONIVEL') {
                Log::warning("Imóvel #{$imovel->id} voltou a estar DISPONÍVEL");
            }
        }

        if ($imovel->wasChanged('ativo')) {
            $ativoAnterior = $imovel->getOriginal('ativo');
            $ativoNovo = $imovel->ativo;
            
            if ($ativoNovo === false) {
                Log::info("Imóvel #{$imovel->id} foi DESATIVADO (soft delete)", [
                    'descricao' => $imovel->descricao
                ]);
            } else {
                Log::info("Imóvel #{$imovel->id} foi RESTAURADO", [
                    'descricao' => $imovel->descricao
                ]);
            }
        }

        $camposAlterados = array_keys($imovel->getChanges());
        
        if (count($camposAlterados) > 1) {
            Log::info("Múltiplos campos do imóvel #{$imovel->id} foram alterados", [
                'campos' => implode(', ', $camposAlterados),
                'quantidade' => count($camposAlterados)
            ]);
        }

        if ($imovel->wasChanged()) {
            $mudancas = [];
            
            foreach ($imovel->getChanges() as $campo => $valorNovo) {
                $valorAntigo = $imovel->getOriginal($campo);
                $mudancas[$campo] = [
                    'de' => $valorAntigo,
                    'para' => $valorNovo
                ];
            }
            
            Log::info("Auditoria: Imóvel #{$imovel->id} atualizado", [
                'alteracoes' => $mudancas,
                'usuario' => 'sistema' 
            ]);
        }
    }

    public function deleting(Imovel $imovel): bool
    {
        if ($imovel->disponibilidade !== 'DISPONIVEL') {
            Log::warning("Tentativa de exclusão de imóvel não disponível", [
                'id' => $imovel->id,
                'disponibilidade' => $imovel->disponibilidade,
                'descricao' => $imovel->descricao
            ]);

            throw new \DomainException(
                'Não é permitido excluir um imóvel que não esteja DISPONÍVEL. ' .
                'Status atual: ' . $imovel->disponibilidade
            );
        }
        return true;
    }

    public function deleted(Imovel $imovel): void
    {
        Log::warning("Imóvel excluído do sistema", [
            'id' => $imovel->id,
            'descricao' => $imovel->descricao,
            'preco_original' => number_format($imovel->preco, 2, ',', '.'),
            'disponibilidade' => $imovel->disponibilidade,
            'data_exclusao' => \Carbon\Carbon::now()->format('d/m/Y H:i:s')
        ]);

        if ($imovel->preco >= 500000) {
            Log::critical("ALERTA: Imóvel de alto valor foi excluído!", [
                'id' => $imovel->id,
                'preco' => 'R$ ' . number_format($imovel->preco, 2, ',', '.'),
            ]);
        }
    }

    public function restored(Imovel $imovel): void
    {
        Log::info("Imovel RESTAURADO no sistema", [
            'id' => $imovel->id,
            'descricao' => $imovel->descricao,
            'preco' => number_format($imovel->preco, 2, ',', '.'),
            'data_restauracao' => \Carbon\Carbon::now()->format('d/m/Y H:i:s')
        ]);
    }

 
    public function saving(Imovel $imovel): bool
    {
        if ($imovel->preco < 0){
            throw new \DomainException('O preço do imovel não pode ser negativo');
        }

        if ($imovel->preco < 1000 && $imovel->preco > 0){
            Log::warning("Imovel com preço muito baixo detectado", [
                'id' => $imovel->id ?? 'novo',
                'preco' => $imovel->preco
            ]);
        }

        return true;
    }

    public function saved(Imovel $imovel): void
    {
        Log::info("Imovel #{$imovel->id} foi salvo no sistema"); 
    }

}
