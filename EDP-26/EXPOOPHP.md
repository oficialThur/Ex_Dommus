
# Exercício POO PHP 

Você deve implementar um pequeno **domínio orientado a objetos** para **reajuste de preços de imóveis**, substituindo completamente abordagens procedurais ou baseadas em closures.

O sistema deverá ser extensível, reutilizável e corretamente encapsulado, fazendo uso explícito de **interfaces, traits, classes abstratas e herança**.

### Requisitos de implementação

Interface **ItemReajustavelInterface**

Crie uma interface chamada **ItemReajustavelInterface** que defina o contrato para itens que podem sofrer reajuste.

A interface deve declarar:

```php
public function reajustar(float $percentual): void;
public function getPreco(): float;
public function getPrecoOriginal(): float;
```
Trait **ReajusteTrait**

Crie uma **trait** chamada **ReajusteTrait**, responsável por **reaproveitar a lógica de reajuste**.

A trait deve:

Implementar o método:
```php    
protected function aplicarReajuste(float    $prcentual): void
```

- Utilizar o operador de resolução de escopo (::) quando necessário

- Presumir que a classe que a utiliza possui:
```php
$preco
$disponibilidade
```
Uma constante STATUS_DISPONIVEL

- A trait não deve validar regras de domínio complexas, apenas aplicar o reajuste quando autorizada.

Classe base **Imovel**

Crie uma classe Imovel que:

- Implemente a interface **ItemReajustavelInterface**

- Utilize a **ReajusteTrait**

Propriedades (com visibilidade adequada):

- id (int)

- descricao (string)

- preco (float)

- precoOriginal (float)

- disponibilidade (string)

Constantes:

```php
public const STATUS_DISPONIVEL = 'DISPONIVEL';
public const STATUS_VENDIDO = 'VENDIDO';
```

Métodos mágicos

A classe **Imovel** deve implementar:



- __construct()

    Inicializa o objeto

    Armazena o preço original

- __get()

    Permite leitura controlada de propriedades

- __set()

    Bloqueia alterações diretas em propriedades sensíveis

- __toString()

    Retorna uma representação textual do imóvel

Implementação do reajuste no **Imovel**

O método exigido pela interface:

```php
public function reajustar(float $percentual): void
```

Deve:

- Validar:

    Percentual positivo

    Disponibilidade igual a self::STATUS_DISPONIVEL

- Delegar a aplicação do reajuste à trait

- Alterar o estado do objeto por referência

Classe abstrata **AbstractReajusteService**

Crie uma classe **abstrata** chamada AbstractReajusteService que:

- Possua um método abstrato:
```php
abstract protected function filtrar(ItemReajustavelInterface $item): bool;
```
- Possua um método concreto:
```php
public function processar(array $itens, float $percentual): array
```
- Trabalhe exclusivamente com o contrato da interface

- Não conheça detalhes da implementação concreta (Imovel)

Classe concreta **ReajusteImovelService**

Crie uma classe **ReajusteImovelService** que:

- Estenda AbstractReajusteService

- Implemente o método filtrar

- Aplique o reajuste apenas aos imóveis válidos

- Utilize métodos estáticos quando apropriado (ex.: validação de percentual)

Entrada de dados

Os dados serão enviados via **POST**, contendo:

- **imoveis** — JSON com a lista de imóveis

- **percentual** — valor numérico positivo

O script deve:

- Converter os dados em objetos **Imovel**

- Garantir tipagem correta

- Tratar entradas inválidas

Saída esperada

Exibir uma listagem contendo:

- ID

- Descrição

- Preço original

- Preço atual

- Disponibilidade

A saída pode ser:

- HTML simples 

Requisitos técnicos obrigatórios

Interface
Trait
Classe abstrata
Herança
Métodos mágicos
Métodos estáticos
Operador de resolução de escopo (::)
Uso correto de visibilidade
Objetos manipulados por referência
PSR-1 e PSR-12

**Não é permitido:**

- Funções globais

- Propriedades públicas sem justificativa

- Lógica de domínio fora das classes


1- Definir interface de reajuste
Criar a interface ItemReajustavelInterface com os métodos exigidos. Explicar o papel da interface e como ela garante o contrato dos itens reajustáveis.

2- Criar trait de reajuste
Desenvolver a trait ReajusteTrait. Explicar como traits funcionam no PHP e como reutilizarão a lógica de reajuste entre classes. Detalhar a função do método aplicarReajuste.

3- Implementar classe base Imovel
Construir a classe Imovel, implementando a interface e usando a trait. Explicar encapsulamento, métodos mágicos e constantes. Detalhar como o reajuste será aplicado e validado.

4- Criar classe abstrata de serviço
Desenvolver a AbstractReajusteService, explicando o conceito de classes abstratas, métodos abstratos e concretos. Mostrar como ela processa itens sem conhecer detalhes concretos.

5- Implementar serviço concreto de reajuste
Criar a classe ReajusteImovelService, herdando da abstrata e implementando o filtro. Explicar uso de métodos estáticos para validação e aplicação do filtro.

6- Montar fluxo de entrada e saída
Explicar como receber dados via POST, converter para objetos, validar e exibir a saída em HTML simples. Detalhar o fluxo de manipulação dos objetos e tratamento de erros.