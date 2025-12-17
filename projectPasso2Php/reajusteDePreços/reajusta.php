<?php

// Define o tipo de conteúdo da resposta como JSON
header('Content-Type: application/json');


// --- CONTROLLER ---
// 1. Validação e recebimento dos dados de entrada (POST)

// Verifica se os dados foram enviados via POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['erro' => 'Método não permitido. Use POST.']);
    exit;
}

// 2. Obter e validar 'percentual' e 'matriz'
$percentual = isset($_POST['percentual']) ? (float)$_POST['percentual'] : 0;
$matrizJson = $_POST['matriz'] ?? null;

$matriz = !empty($matrizJson) ? json_decode($matrizJson, true) : null;

if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(['erro' => 'O formato da matriz JSON é inválido.']);
    exit;
}

if (empty($matriz)) {
    http_response_code(400); // Bad Request
    echo json_encode(['erro' => 'Dados inválidos. A "matriz" de imóveis não pode estar vazia.']);
    exit;
}

// --- MODEL (A Lógica de Negócio) ---

/**
 * @var Closure $reajustaImovel
 * Esta é a closure. Ela é uma função anônima atribuída a uma variável.
 * Ela recebe um imóvel por vez e aplica a regra de negócio.
 */
$reajustaImovel = function (array $imovel) use ($percentual): array {
    // Validação: Garante que as chaves essenciais existem no array do imóvel.
    if (!isset($imovel['preco'], $imovel['disponibilidade'])) {
        return $imovel + ['erro' => 'Dados do imóvel incompletos'];
    }
    // Primeiro, sempre guardamos o preço antigo.
    $imovel['preco_antigo'] = $imovel['preco'];

    // CONDIÇÕES PARA O AUMENTO (ambas devem ser verdadeiras)
    // 1. O percentual de reajuste é positivo?
    // 2. O imóvel está disponível?
    if ($percentual > 0 && $imovel['disponibilidade'] === 'DISPONIVEL') {
        // Se AMBAS as condições forem atendidas, calculamos o novo preço...
        $novoPreco = $imovel['preco'] * (1 + $percentual / 100);
        // ...e adicionamos o campo 'preco_novo' ao array do imóvel.
        $imovel['preco_novo'] = round($novoPreco, 2); // round() para evitar problemas com dízimas.
    }

    // Retornamos o array do imóvel, modificado ou não.
    return $imovel;
};

// --- APLICAÇÃO E VIEW ---

// Usamos array_map para aplicar a closure a cada item da matriz.
$resultado = array_map($reajustaImovel, $matriz);

// Exibe o resultado final em formato JSON.
echo json_encode($resultado, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

?>