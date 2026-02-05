# Encaminhamento de XML para o JsonPlaceholder usando PUT em PHP

Implemente um script PHP encaminharxml.php que receba, via requisição HTTP, um documento  <strong> XML </strong> contendo os dados de um recurso semelhante ao /posts do JsonPlaceholder.
O script deve:

    1.Receber o id do recurso por query string (ex.: ?id=3)

    2.Receber o corpo XML do recurso por PUT

    3.Converter o XML recebido para JSON (mantendo os campos esperados pelo JsonPlaceholder)

    4.Usar a extensão cURL do PHP para enviar um PUT para o endpoint:

<strong> https://jsonplaceholder.typicode.com/posts/{id} </strong>

    5.Retronar para o cliente:

        O status HTTP da operação no JsonPlaceholder

        O corpo retornado pela API

## Formato esperado pelo JsonPlaceholder (JSON)

```json
    {
        "id": 1,
        "title": "foo",
        "body": "bar",
        "userId": 1
    }
```
Seu script receberá XML, mas o envio ao JsonPlaceholder será em <strong>JSON</strong>.

## Mock da requisição cURL

Envie o XML por <strong>PUT</strong> com --data:

```bash
    curl --location --request PUT 'http://localhost/encaminhar_xml.php?id=1' \
    --header 'Content-Type: application/xml' \
    --data-binary '<?xml version="1.0" encoding="UTF-8"?>
    <post>
        <id>1</id>
        <titulo>foo</titulo>
        <corpo>bar</corpo>
        <usuario>1</usuario>
    </post>'
```
## Exemplo de resposta esperada
```json
    {
        "status": 200,
        "response": {
            "id": 1,
            "title": "foo",
            "body": "bar",
            "userId": 1
        }
    }
```

