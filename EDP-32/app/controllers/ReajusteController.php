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

            if (empty($this->erros)) {
                $this->dadosValidos = true;
            }
        }
    }

private function converterEProcessar() {
    try {
            $percentual = (float) $_POST['percentual'];

            $servico = new ReajusteImovelService(DaoFactory::createImovelDao());
            $this->itensProcessados = $servico->processar([], $percentual);

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