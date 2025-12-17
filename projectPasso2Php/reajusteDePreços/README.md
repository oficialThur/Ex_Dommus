# Reajuste de preços de imóveis usando closure em PHP

Implemente um script PHP <strong> reajusta.php </strong> capaz de aplicar um reajuste percentual sobre os preços de uma lista de imóveis.
A lista será fornecida como uma matriz (array multidimensional) enviada por <strong> POST </strong> em formato JSON, junto com um <strong> percentual de reajuste positivo </strong>.

Cada linha da matriz representa um imóvel com os seguintes campos: 

    ** id ** — inteiro

    ** descricao ** — texto curto

    ** preco ** — número real

    ** disponibilidade **  — string contendo ** DISPONIVEL ** ou ** VENDIDO **

## Requisitos do script

    * Ler os dados enviados por POST:

        - matriz (JSON contendo o array de imóveis)

        - percentual (valor numérico positivo)
    
    * Criar uma closure que:

        Receba uma linha da matriz (um imóvel) e o percentual

        Aplique o reajuste somente se:

            - o percentual for positivo

            - a disponibilidade do imóvel for DISPONIVEL

        Retorne o array da linha atualizado (incluindo preço antigo e novo)

    * Processar toda a matriz usando a closure.

    * Exibir a listagem resultante contendo:

        - ID

        - Descrição

        - Preço antigo

        - Preço novo (apenas se foi reajustado)

        - Disponibilidade

## Mock da requisição cURL

O exemplo abaixo envia a matriz e o percentual por POST:

```json
    curl --location 'http://localhost/reajuste.php' \
    --form 'percentual="8"' \
    --form 'matriz="[
        {
            \"id\": 1,
            \"descricao\": \"Apartamento 80m² Centro\",
            \"preco\": 350000,
            \"disponibilidade\": \"DISPONIVEL\"
        },
        {
            \"id\": 2,
            \"descricao\": \"Casa 120m² Bairro Verde\",
            \"preco\": 480000,
            \"disponibilidade\": \"VENDIDO\"
        },
        {
            \"id\": 3,
            \"descricao\": \"Kitnet 30m²\",
            \"preco\": 150000,
            \"disponibilidade\": \"DISPONIVEL\"
        }
    ]"'
```

## Saída esperada (exemplo)

```json
    [
        {
            "id": 1,
            "descricao": "Apartamento 80m² Centro",
            "preco": 350000,
            "disponibilidade": "DISPONIVEL",
            "preco_novo": 378000,
            "preco_antigo": 350000
        },
        {
            "id": 2,
            "descricao": "Casa 120m² Bairro Verde",
            "preco": 480000,
            "disponibilidade": "VENDIDO",
            "preco_antigo": 480000
        },
        {
            "id": 3,
            "descricao": "Kitnet 30m²",
            "preco": 150000,
            "disponibilidade": "DISPONIVEL",
            "preco_novo": 162000,
            "preco_antigo": 150000
        }
    ]
```
A seguir está o exercício totalmente padronizado, seguindo o mesmo estilo dos exercícios anteriores:

    ✔ enunciado claro
    ✔ requisitos técnicos específicos
    ✔ uso de PUT, XML, cURL do PHP
    ✔ leitura por query string + corpo XML
    ✔ mock da requisição em cURL

---    


// Define o tipo de conteúdo da resposta como JSON
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST'){
// --- CONTROLLER ---
// 1. Validação e recebimento dos dados de entrada (POST)

// Verifica se os dados foram enviados via POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['erro' => 'Método não permitido. Use POST']);
    echo json_encode(['erro' => 'Método não permitido. Use POST.']);
    exit;
}

// 2. Obter e validar 'percentual' e 'matriz'
$percentual = isset($_POST['percentual']) ? (float)$_POST['percentual'] : 0;
$matrizJson = $_POST['matriz'] ?? null;

if ($percentual <= 0 || empty($matrizJson)) {
    http_response_code(400); // Bad Request
    echo json_encode(['erro' => 'Dados inválidos. Forneça um "percentual" positivo e uma "matriz" de imóveis.']);
    exit;
}

$matriz = json_decode($matrizJson, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(['erro' => 'O formato da matriz JSON é inválido.']);
    exit;
}

// --- MODEL (A Lógica de Negócio) ---

/**
 * @var Closure $reajustaImovel
 * Esta é a closure. Ela é uma função anônima atribuída a uma variável.
 * Ela recebe um imóvel por vez e aplica a regra de negócio.
 */
$reajustaImovel = function (array $imovel) use ($percentual): array {
    // Primeiro, sempre guardamos o preço antigo.
    $imovel['preco_antigo'] = $imovel['preco'];

    // A condição principal: o imóvel está disponível?
    if ($imovel['disponibilidade'] === 'DISPONIVEL') {
        // Se sim, calculamos o novo preço...
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


