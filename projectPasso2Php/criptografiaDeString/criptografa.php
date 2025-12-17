<?php

// 3. Usar openssl_encrypt para criptografar o texto (o algoritmo pode ser definido como constante).
define('ENCRYPTION_METHOD', 'AES-256-CBC');

// 4. Gerar uma chave e IV fixos para fins de exercício.
// A chave deve ter 32 bytes para AES-256 e o IV 16 bytes para CBC.
$key = substr(hash('sha256', 'minha-chave-secreta-fixa'), 0, 32);
$iv = substr(hash('sha256', 'meu-iv-fixo'), 0, 16);

// 1. Ler o parâmetro texto enviado via GET.
$textoParaCriptografar = $_GET['texto'] ?? null;

// 2. Validar se o valor foi informado.
if (empty($textoParaCriptografar)) {
    http_response_code(400);
    die("Erro: O parâmetro 'texto' é obrigatório e não foi informado.");
}

// 3. Criptografar o texto.
$textoCriptografado = openssl_encrypt(
    $textoParaCriptografar,
    ENCRYPTION_METHOD,
    $key,
    0, 
    $iv
);

// 5. Armazenar o texto criptografado em um cookie chamado texto_criptografado.
setcookie('texto_criptografado', $textoCriptografado, time() + 3600, "/");

// 6. Retornar para o usuário uma mensagem informando que o cookie foi definido.
echo "Cookie 'texto_criptografado' definido com sucesso!";

?>