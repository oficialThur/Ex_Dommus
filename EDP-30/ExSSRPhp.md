# Exercício SSR com PHP

Neste exercício, toda a renderização deve ocorrer no **servidor**, utilizando PHP para consumir a API da SWAPI e **retornar HTML pronto ao cliente**.

⚠️ Diferente de exercícios introdutórios, **o uso de echo é permitido e esperado**, porém **o HTML final deve ser construído utilizando Output Buffer**, simulando o padrão adotado em aplicações SSR reais.

A API a ser consumida é: https://swapi.info/api/planets

Você deve implementar um pequeno sistema **SSR em PHP** que responda de forma diferente de acordo com um parâmetro action recebido na requisição (GET).

O HTML retornado ao cliente **deve ser montado via Output Buffer**, mesmo quando forem utilizados echo dentro de templates ou classes.

Ações suportadas
```php
action=buscar
```
Busca um planeta específico pelo **ID**.

Entrada esperada
```php
?action=buscar&id=3
```
Saída esperada

    - Um <div> HTML, renderizado no servidor, contendo:

        - Nome do planeta

        - População do planeta

Exemplo conceitual:

```html
<div class="planeta">
  <h2>Tatooine</h2>
  <p>População: 200000</p>
</div>
```
```php
action=listar
```

Lista todos os planetas disponíveis na API.

Entrada esperada
```php
?action=listar
```

Saída esperada

    Uma tabela HTML completa, contendo:

        Nome

        Terreno

        População

## Requisitos de implementação

### Classe Cliente da API

Crie uma classe (ex.: SwapiClient) responsável por:

    Realizar requisições HTTP à SWAPI

    Buscar:

        Um planeta por ID

        A lista de planetas

    Retornar os dados como array PHP

    Não gerar HTML

Essa classe deve ser incluída utilizando require_once, por ser uma dependência obrigatória do sistema.

### Classe Geradora de HTML (SSR)

Crie uma classe (ex.: PlanetaHtmlRenderer) responsável por:

    Gerar HTML usando echo

    Utilizar Output Buffer internamente para:

        Capturar o HTML gerado

        Retornar o conteúdo como string

    Possuir métodos como:

        renderPlaneta(array
        		$planeta): string

        renderTabela(array
        		$planetas): string

Essa classe deve ser incluída usando include_once.

⚠️ O uso de echo sem Output Buffer será considerado erro conceitual.

### Templates HTML (quando aplicável)

Caso o aluno opte por separar HTML em arquivos de template:

    Os templates devem:

        Usar echo

        Ser incluídos com include_once

        Ser renderizados dentro de um Output Buffer

### Script Controlador (Front Controller)

Crie um script principal (ex.: index.php) responsável por:

    Ler o parâmetro action

    Validar entradas (id, quando aplicável)

    Instanciar o cliente da API

    Delegar:

        A busca de dados ao cliente

        A renderização à classe de HTML

    Exibir o HTML final retornado pelo Output Buffer

Nenhuma chamada direta à API ou HTML complexo deve existir fora das classes apropriadas.

### Uso obrigatório de Output Buffer

O exercício exige explicitamente o uso de:
```
ob_start, ob_get_clean ou ob_end_flush
```
O aluno deve demonstrar que compreende:

    Por que capturar a saída

    Como montar HTML de forma controlada

    Como retornar HTML como string em SSR

### Requisitos técnicos obrigatórios

SSR com PHP
Uso de Output Buffer
Uso permitido e consciente de echo
Parâmetro action controlando o fluxo
Classe cliente para API
Classe separada para geração de HTML
Uso correto de require_once
Uso correto de include_once
Código organizado em múltiplos arquivos

### Não é permitido:

- Retornar HTML diretamente do controller sem buffer

- Misturar lógica de requisição com renderização

- JavaScript para manipulação de DOM

- Código monolítico em um único arquivoSessão de Entrega
