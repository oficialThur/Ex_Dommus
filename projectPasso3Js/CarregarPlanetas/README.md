# Exercício 5 - Funções Assíncronas

## Crie um arquivo chamado carregar-planetas.js e inclua-o em um HTML utilizando a tag:
```HTML
    <script src="carregar-planetas.js"></script>
```

No HTML já existem:

    Um botão com id btnCarregarPlanetas

    Uma tabela com id tabelaPlanetas, contendo apenas o <thead>

    Um input numérico com id minPopulacao

A API a ser consumida é:

### API Endpoint:
    https://swapi.info/planets

### Comportamento esperado

Ao clicar no botão Carregar Planetas, execute o seguinte fluxo:

## Validação inicial

    Leia o valor do input minPopulacao

    Utilize curto-circuito lógico para abortar a execução caso:

        o valor não exista

        ou seja menor que zero


## Consumo da API (Promise)

    Crie uma função buscarPlanetas() que:

        Utilize fetch

        Retorne uma Promise

        Resolva com a lista de planetas retornada pela API

        Rejeite em caso de erro HTTP ou falha de rede

## Processamento assíncrono dos dados

    Para cada planeta retornado pela API:

        Considere apenas planetas cuja population seja numérica e maior ou igual ao valor informado

        Ignore planetas com population === "unknown"

## Criação assíncrona das linhas da tabela

Crie uma função assíncrona chamada:
```Js
    async function criarLinhaPlaneta(planeta)
```
Essa função deve:

    Retornar uma Promise

    Criar dinamicamente uma <tr> contendo:

        name

        terrain

        population

    Resolver a Promise com a <tr> pronta para inserção no DOM

### ⚠️ Importante:
Mesmo sendo uma operação simples, a função deve ser assíncrona para avaliar domínio do modelo mental de Promises.

## Inserção no DOM

    Utilize async/await para:

        Aguardar a criação de cada linha

        Inserir a <tr> no <tbody> da tabela

    A tabela deve ser construída somente após a Promise da API ser resolvida

## Estruturação de dados

    Construa um Map onde:

        chave: nome do planeta

        valor: objeto contendo:

            terrain

            population

## Tratamento de erros

    Utilize try/catch

    Em caso de erro:

        Registre no console uma mensagem clara

        Não deixe o erro “silencioso”

## Console

    Imprima:

        O Map convertido para JSON

        O tempo total de execução do processo usando:

        console.time()
        console.timeEnd()

## Requisitos técnicos obrigatórios

Para resolver este exercício, é obrigatório utilizar:

    fetch

    Promise

    async / await

    Funções assíncronas com arrow function

    Curto-circuito lógico

    Map

    Manipulação do DOM

    try / catch

    Conversão para JSON

    console.time
