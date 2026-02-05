<?php

header('Content-Type: application/json');

const SOMA = 'SOMA';
const SUBTRACAO = 'SUBTRACAO';
const MULTIPLICACAO = 'MULTIPLICACAO';
const DIVISAO = 'DIVISAO';

function calcular(float $esquerda, float $direita, string $operacao)
{
    switch ($operacao) {
        case SOMA:
            return $esquerda + $direita;

        case SUBTRACAO:
            return $esquerda - $direita;

        case MULTIPLICACAO:
            return $esquerda * $direita;

        case DIVISAO:
            if ($direita == 0) {
                throw new Exception('Divisão por zero não é permitida');
            }
            return $esquerda / $direita;

        default:
            throw new Exception('Operação inválida');
    }
}
try {
    $json = file_get_contents('php://input');
    $dados = json_decode($json, true);
        if (!isset($dados['esquerda'], $dados['direita'], $dados['operacao'])) {
        throw new Exception('Parâmetros obrigatórios ausentes');
    }

    if (!is_numeric($dados['esquerda']) || !is_numeric($dados['direita'])) {
        throw new Exception('Os operandos devem ser numéricos');
    }

    $operacoesValidas = [SOMA, SUBTRACAO, MULTIPLICACAO, DIVISAO];
    if (!in_array($dados['operacao'], $operacoesValidas)) {
        throw new Exception('Operação não suportada');
    }
    
    $resultado = calcular(
    (float)$dados['esquerda'],
    (float)$dados['direita'],
    $dados['operacao']
    );

    echo json_encode([
        'entrada' => [
            'esquerda' => $dados['esquerda'],
            'direita' => $dados['direita'],
            'operacao' => $dados['operacao']
        ],
        'resultado' => $resultado,
        'tipo_resultado' => gettype($resultado)
    ]);
}

catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'erro' => $e->getMessage()
    ]);
}

?>