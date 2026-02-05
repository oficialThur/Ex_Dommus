# Uso de call, apply e bind com objetos Locáveis

## Objetivo

Praticar manipulação de contexto (this) em JavaScript utilizando os métodos <strong>call, apply e bind</strong>, aplicando um método compartilhado (alugar) sobre diferentes objetos, e inspecionando o resultado no console.

Você deverá criar um exercício que utiliza o mesmo módulo Locavel usado no exercício anterior (ou receberá um módulo equivalente), e aplicar o método alugar() em diferentes objetos que <strong>não herdam</strong> diretamente de Locavel, demonstrando o uso das três funções de manipulação de contexto: <strong>call, apply e bind</strong>.

## Parte A — Arquivo locavel.js (fornecido novamente para referência)

Crie (ou reutilize) um arquivo chamado locavel.js, exportando um objeto literal base:

```JS
    export default {
        alugado: false,
        alugar() {
            this.alugado = true;
        }
    };
```

Esse objeto será a <strong> fonte </strong> do método alugar(), mas <strong> não haverá prototype chain neste exercício </strong>.    

## Parte B — Criar imoveis hardcoded

Crie um arquivo <strong> call-bind-apply.js </strong> que deverá ser executado no navegador como módulo ES.

Neste arquivo:

    1.Importe Locavel:
```JS
    import Locavel from "./locavel.js";
```
    2.Crie três imóveis hardcoded, sem herança, apenas objetos literais independentes:
```JS
    const imovelA = { id: 1, valor_aluguel: 1800, alugado: false };
    const imovelB = { id: 2, valor_aluguel: 2200, alugado: false };
    const imovelC = { id: 3, valor_aluguel: 1500, alugado: false };
```
    3.O objetivo será aplicar o método alugar, que existe apenas em Locavel, usando:
        
        call
        apply
        bind

## Parte C — Aplicar call, apply e bind

Execute as seguintes operações:

### 1. Usar call()

Aplique o método alugar a imovelA:    

### 2. Usar apply()

Aplique o método alugar a imovelB usando apply():

### 3. Usar bind()

    Crie uma função já vinculada ao contexto de imovelC usando bind:

    Execute essa função vinculada.

## Parte D — Imprimir o estado resultante

Após cada operação, imprima no console o estado atualizado dos imóveis, usando console.log com serialização JSON:

```JS
    console.log("A:", JSON.stringify(imovelA, null, 2));
    console.log("B:", JSON.stringify(imovelB, null, 2));
    console.log("C:", JSON.stringify(imovelC, null, 2));
```

Os três devem mostrar "alugado": true.

## Requisitos técnicos obrigatórios

    Uso explícito de call, apply e bind — cada um aplicado a um objeto distinto.

    Os imóveis não devem usar prototype chain ou herança.

    O script deve ser executado diretamente no console da aba do navegador.

    Importação via ES Module (import Locavel …).

    Serialização usando JSON.stringify().
