<?php

header('Content-Type: application/json');
$id = $_GET['id'];

if($_SERVER['REQUEST_METHOD'] !== 'PUT'){
    http_response_code(405);
    echo json_encode(['error' => 'Use outro metodo']);
    exit;
}

$xmlString = file_get_contents('php://input');

if(empty($xmlString)){
    http_response_code(400);
    echo json_encode(['error' => 'Xml não enviado']);
    exit;
}

$xmlObject = simplexml_load_string($xmlString);

if ($xmlObject === false) {
    http_response_code(400);
    echo json_encode(['error' => 'XML mal formatado']);
    exit;
}

$postData = [
    'title'  => (string) $xmlObject->titulo,
    'body'   => (string) $xmlObject->corpo,
    'userId' => (int) $xmlObject->usuario,
    'id'     => (int) $id 
];

$jsonPayload = json_encode($postData);

// Usar a extensão cURL para enviar o PUT
$url = "https://jsonplaceholder.typicode.com/posts/{$id}";

// Verifica se a extensão cURL está habilitada antes de tentar usá-la
if (!function_exists('curl_init')) {
    http_response_code(500);
    echo json_encode(['error' => 'A extensão cURL não está instalada ou habilitada no servidor PHP.']);
    exit;
}

$ch = curl_init($url);

if ($ch === false) {
    http_response_code(500); 
    echo json_encode(['error' => 'Falha ao inicializar a sessão cURL.']);
    exit;
}

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonPayload);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Content-Length: ' . strlen($jsonPayload)
]);

$apiResponse = curl_exec($ch);

if ($apiResponse === false) {
    $curlError = curl_error($ch); 
    http_response_code(500); 
    echo json_encode(['error' => 'Falha na comunicação com a API externa.', 'curl_error' => $curlError]);
    exit;
}
$httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);


http_response_code(200); 

echo json_encode([
    'status' => $httpStatusCode,
    'response' => json_decode($apiResponse)
]);
?>