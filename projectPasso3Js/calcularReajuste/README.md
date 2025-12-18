# Manipulação do DOM, validação, iteráveis, objetos e console

<strong>Objetivo:</strong> praticar inclusão de scripts no HTML, leitura de valores de entrada, validação, iteração de nós do DOM, criação de estruturas de dados (Map) e impressão no console.

Crie um arquivo calcular-reajuste.js e inclua-o no HTML usando a tag 
```html
    <script src="..."></script>
```
Adicione a este comportamento conforme descrito abaixo.

Ao clicar no botão:

    1. Leia o valor do input e valide se o reajuste é positivo (use curto-circuito lógico para abortar em caso inválido).

    2. Se válido, itere as linhas da tabela (exceto o cabeçalho).

    3. Construa um Map, onde

         chave → ID do imóvel

         valor → Objeto contendo as informações do imóvel ( descrição, preço - reajustado quando disponível, e disponibilidade)

    4. Imprima o Map no console como objeto JSON.

Para resolver este exercício utilize de:

    Objetos,

    Função anônima com arrow function

    curto-circuito lógico.
