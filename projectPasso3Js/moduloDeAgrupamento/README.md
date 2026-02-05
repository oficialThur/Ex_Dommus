# Exercício 2 — Módulos ES, arrow functions, reduce, programação funcional, fetch e mensagens entre scripts

<strong>Objetivo:</strong> praticar módulos, arrow functions, programação funcional, consumo de API, agrupamento de dados, mensagens, e eventos.

### Parte A — Criar módulo de agrupamento

Crie um arquivo <strong>groupBy.js</strong>, exportando uma arrow function.

A função deve:

    Receber um array de objetos.
    Um nome de atributo existente nos objetos
    Reduzir esse array em um objeto cujas chaves são valores do atributo passado.
        Cada chave deve conter um array de itens daquele grupo.
        Caso o atributo não exista em um objeto, este deve ser ignorado.
    Retornar o objeto contendo os arrays agrupados pelo atributo

Use <strong>reduce</strong> obrigatoriamente.

### Parte B — Consumir API e enviar dados com postMessage

Crie um arquivo <strong>starships.js</strong> que:

    1. Faça uma requisição GET com fetch para https://swapi.info/starships
    2. Importe o módulo groupBy.js.
    3. Agrupe as naves pelo atributo starship_class.
    4. Envie o objeto resultante a outra aba

### Parte C — Capturar mensagem e imprimir no console

Crie um terceiro arquivo <strong>listener.js</strong> que:

    1. Adicione um listener para  o evento emitido em starships.js

    2. Imprima no console o objeto recebido em formato JSON ( https://developer.mozilla.org/pt-BR/docs/Web/JavaScript/Reference/Global_Objects/JSON ).

## Crie o arquivo index.html para iniciar o processo

Este arquivo apenas carrega starships.js, que fará o fetch e enviará dados à outra aba.

### Como testar:

    1. Abra duas abas do navegador:
        Aba A → index.html
        Aba B → listener.html
    2. A aba A irá buscar a API, agrupar os dados e enviar para a aba B usando postMessage.

Use este HTML:

```HTML
    <!DOCTYPE html>
    <html lang="pt-BR">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <<title>Teste Starships</title>
    </head>

    <body>
        <h1>Teste do starships.js</h1>
        <p>Abra também o arquivo listener.html em outra aba.</p>

        <script type="module" src="scripts/starships.js"></script>
    </body>

    </html>
```

## Crie o arquivo listener.html para receber a mensagem

Este arquivo carrega listener.js, responsável por capturar o postMessage e imprimir no console.

### Como testar:

    1.Abra o DevTools → Console desta aba.
    2.Aguarde a mensagem vinda da outra aba.

Use este HTML:

```HTML
    <!DOCTYPE html>
    <html lang="pt-BR">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Listener</title>
    </head>

    <body>
        <h1>Listener</h1>
        <p>Esta aba receberá a mensagem da outra aba.</p>

        <script type="module" src="scripts/listener.js"></script>
    </body>

    </html>    
```