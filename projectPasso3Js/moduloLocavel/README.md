# Prototype Chain com módulo Locavel

## Objetivo

Praticar prototype chain, herança manual via funções construtoras, sobrescrita de métodos, importação de módulos ES e serialização simples de objetos. Você deverá implementar o exercício utilizando prototype chain em JavaScript, no qual será fornecido um módulo contendo um objeto base chamado <strong>Locavel</strong>.

## Parte A — Arquivo locavel.js

Você deve <strong>escrever</strong> o arquivo locavel.js exportando um objeto literal chamado <strong>Locavel</strong>, contendo:

    id → número

    valor_aluguel → número

    alugado → booleano (padrão: false)

    alugar() → método que altera alugado para true

O módulo deve ser exportado usando <strong>export default</strong>.

## Parte B — Extender Locavel em um construtor Imovel

Crie um arquivo <strong>imovel.js</strong> que:

    1.Importe Locavel do arquivo locavel.js.

    2.Defina uma função construtora chamada Imovel.

    3.Dentro do construtor:

        Receba id e valor_aluguel como parâmetros.

        Crie um atributo adicional chamado disponibilidade, cujo valor inicial deve ser "DISPONIVEL".

    4.Ajuste o [[Prototype]] de Imovel.prototype para herdar de Locavel.

    5.Sobrescreva o método alugar() no prototype de Imovel para:

        Alterar disponibilidade para "ALUGADO".

        Não alterar o método original de Locavel; apenas sobrescreva no nível de Imovel.

Critérios obrigatórios:

    Não utilizar class.

    Utilizar prototype chain puro com funções construtoras.
    
    Demonstrar claramente a sobrescrita.

## Parte C — Execução direta no console

Crie um arquivo <strong>main.js</strong> que será executado diretamente no navegador (via console devtools).

O script deve:

    1.Importar Imovel.
    2.Declarar um imóvel hardcoded, por exemplo:
```JS
    const ap101 = new Imovel(101, 2500);
```
    3.Invocar o método sobrescrito:
```JS
    ap101.alugar();
```        
    4.Serializar seu estado em JSON e imprimir no console:
```JS
    console.log(JSON.stringify(ap101, null, 2));
```
    5.Demonstrar visualmente que:
        disponibilidade é "ALUGADO";
        alugado continua herdado de Locavel, mas só será alterado se você optar por chamar o método original via prototype.                

### Requisitos técnicos obrigatórios
    
    Prototype chain deve ser manipulada com Object.setPrototypeOf().

    Não utilizar sintaxe class.

    Exportação/importação via ES Modules (export default e import).

    O estado serializado deve ser impresso com JSON.stringify().

    A execução é feita no console do navegador, não em HTML.
                