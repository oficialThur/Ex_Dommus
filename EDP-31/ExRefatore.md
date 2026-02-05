# Exercício Prática de Refatoração

Você recebeu um script PHP legado responsável por **encaminhar dados de um recurso em XML para uma API externa**, convertendo o conteúdo para JSON e realizando um PUT via cURL.

O script **funciona**, mas foi escrito sem qualquer preocupação com qualidade de código, manutenibilidade ou boas práticas.

Seu papel é **limpar o código**, sem alterar o comportamento final.

Você deve **refatorar completamente** o script legado apresentado abaixo, aplicando **Clean Code, SRP e DRY**.

**A funcionalidade final deve permanecer exatamente a mesma.**

```php
<?php

$id = $_GET['id'];

$raw = file_get_contents('php://input');

$x = simplexml_load_string($raw);

$a = [];
$a['id'] = (int)$id;
$a['title'] = (string)$x->title;
$a['body'] = (string)$x->body;
$a['userId'] = (int)$x->userId;

$j = json_encode($a);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://jsonplaceholder.typicode.com/posts/' . $id);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ch, CURLOPT_POSTFIELDS, $j);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Content-Length: ' . strlen($j)
]);

$r = curl_exec($ch);
$h = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo $h;
echo "\n";
echo $r;
```
## Problemas intencionais do código

O código acima **deliberadamente viola**:

- SRP (tudo em um único fluxo)

- DRY (lógica acoplada e impossível de reaproveitar)

- Clean Code:

    Variáveis sem significado ($x, $a, $j, $r)

    Funções inexistentes

    Ausência total de tratamento de erros

    Dependências concretas acopladas

    Fluxo difícil de testar

Você deve **reescrever a solução**, aplicando:

**Clean Code** aplicado a funções

    Funções pequenas

    Uma responsabilidade por função

    Nomes claros e autoexplicativos

    Sem efeitos colaterais ocultos

**Princípio da Responsabilidade Única (SRP)**

Separe claramente responsabilidades como, por exemplo:

    Leitura de entrada HTTP

    Conversão de XML para estrutura interna

    Serialização para JSON

    Comunicação HTTP via cURL

    Formatação da resposta ao cliente

Cada responsabilidade deve estar em **função ou classe própria.**

## DRY

    Nenhuma lógica duplicada

    Nenhuma dependência hardcoded espalhada

    Configurações centralizadas

    Código reaproveitável

## Estrutura mínima esperada

A solução final deve conter, no mínimo:

    Uma classe responsável por converter XML em array

    Uma classe responsável por comunicação HTTP (cURL)

    Uma função ou classe responsável por orquestrar o fluxo

    Tratamento básico de erros usando exceptions

⚠️ A forma exata da arquitetura fica a critério do aluno, desde que os princípios sejam respeitados.

## Requisitos técnicos obrigatórios

Código organizado em funções e/ou classes
Funções pequenas e coesas
Nomes claros e sem abreviações obscuras
Nenhuma lógica duplicada
Uso de exceções para erros
Manutenção do comportamento funcional

## Não é permitido:

    Reescrever apenas “organizando melhor” o mesmo script

    Manter variáveis com nomes genéricos

    Criar uma única classe “faz tudo”

    Alterar o contrato da API externa

