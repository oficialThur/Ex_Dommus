<?php

class ReajusteController {
    private $erros = [];
    private $dadosValidos = false;
    private $itensProcessados = [];

    public function processar() {
        $this->validarDados();
        if ($this->dadosValidos) {
            $this->converterEProcessar();
        }
        $this->exibirResultados();
    }

    private function validarDados() {
        $this->erros = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST)) {
            // Validação do Percentual
            if (!isset($_POST['percentual']) || $_POST['percentual'] === '') {
                $this->erros[] = "O campo 'percentual' é obrigatório.";
            } else {
                $percentual = filter_var($_POST['percentual'], FILTER_VALIDATE_FLOAT);
                if ($percentual === false) {
                    $this->erros[] = "O campo 'percentual' deve ser um número decimal válido.";
                }
            }

            // Validação do JSON de Imóveis
            if (!isset($_POST['imoveis']) || empty($_POST['imoveis'])) {
                $this->erros[] = "O campo 'imoveis' (JSON) é obrigatório.";
            } else {
                $json = json_decode($_POST['imoveis'], true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    $this->erros[] = "O campo 'imoveis' contém um JSON inválido.";
                } elseif (!is_array($json)) {
                    $this->erros[] = "O JSON de imóveis deve ser uma lista (array).";
                }
            }

            if (empty($this->erros)) {
                $this->dadosValidos = true;
            }
        }
    }

private function converterEProcessar() {
    try {
            $dadosImoveis = json_decode($_POST['imoveis'], true);
            $percentual = (float) $_POST['percentual'];

        $servico = new ReajusteImovelService();
            $this->itensProcessados = $servico->processar($dadosImoveis, $percentual);

    } catch (Exception $e) {
        $this->erros[] = "Erro ao processar dados: " . $e->getMessage();
        $this->dadosValidos = false;
    }
}

    private function exibirResultados() {
        if ($this->dadosValidos && !empty($this->itensProcessados)) {
            $itens = $this->itensProcessados;
            include __DIR__ . '/../views/resultado.php';
        } else {
            $erros = $this->erros;
            include __DIR__ . '/../views/form.php';
        }
    }
}