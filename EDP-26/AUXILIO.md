
# Título do Projeto

Uma breve descrição sobre o que esse projeto faz e para quem ele é

# Programação Orientada a Objetos (POO) em PHP

Vou explicar POO em PHP de forma clara, começando pela sintaxe básica e evoluindo para conceitos de orientação a objetos.

## Sintaxe Básica do PHP

### Estrutura de um arquivo PHP
```php
<?php
// Código PHP aqui

// Imprimir na tela
echo "Olá, mundo!";
print "Outra forma de imprimir";

// Variáveis (sempre começam com $)
$nome = "João";
$idade = 25;
$altura = 1.75;
$ativo = true;

// Concatenação
echo "Meu nome é " . $nome . " e tenho " . $idade . " anos";
echo "Meu nome é $nome"; // Interpolação em aspas duplas

// Arrays
$frutas = ["maçã", "banana", "laranja"];
$frutas = array("maçã", "banana", "laranja"); // Forma antiga

// Array associativo
$pessoa = [
    "nome" => "Maria",
    "idade" => 30
];

// Estruturas de controle
if ($idade >= 18) {
    echo "Maior de idade";
} else {
    echo "Menor de idade";
}

// Loops
for ($i = 0; $i < 10; $i++) {
    echo $i;
}

foreach ($frutas as $fruta) {
    echo $fruta;
}

// Funções
function somar($a, $b) {
    return $a + $b;
}

$resultado = somar(5, 3);
?>
```

## Programação Orientada a Objetos

### 1. Classes e Objetos

```php
<?php
// Definindo uma classe
class Pessoa {
    // Propriedades (atributos)
    public $nome;
    public $idade;
    private $cpf; // Não acessível fora da classe
    protected $email; // Acessível na classe e subclasses
    
    // Construtor - executado ao criar objeto
    public function __construct($nome, $idade, $cpf) {
        $this->nome = $nome;
        $this->idade = $idade;
        $this->cpf = $cpf;
    }
    
    // Métodos (funções da classe)
    public function apresentar() {
        return "Olá, meu nome é {$this->nome} e tenho {$this->idade} anos";
    }
    
    // Getter para propriedade privada
    public function getCpf() {
        return $this->cpf;
    }
    
    // Setter para propriedade privada
    public function setCpf($cpf) {
        $this->cpf = $cpf;
    }
}

// Criando objetos (instâncias)
$pessoa1 = new Pessoa("João", 25, "123.456.789-00");
echo $pessoa1->apresentar();
echo $pessoa1->nome; // Acessa propriedade pública
echo $pessoa1->getCpf(); // Acessa CPF através do getter
?>
```

### 2. Encapsulamento

Controle de acesso às propriedades e métodos:

```php
<?php
class ContaBancaria {
    private $saldo; // Não pode ser acessado diretamente
    private $titular;
    
    public function __construct($titular, $saldoInicial = 0) {
        $this->titular = $titular;
        $this->saldo = $saldoInicial;
    }
    
    public function depositar($valor) {
        if ($valor > 0) {
            $this->saldo += $valor;
            return true;
        }
        return false;
    }
    
    public function sacar($valor) {
        if ($valor > 0 && $valor <= $this->saldo) {
            $this->saldo -= $valor;
            return true;
        }
        return false;
    }
    
    public function getSaldo() {
        return $this->saldo;
    }
}

$conta = new ContaBancaria("Maria", 1000);
$conta->depositar(500);
echo $conta->getSaldo(); // 1500
// echo $conta->saldo; // ERRO! Propriedade privada
?>
```

### 3. Herança

```php
<?php
// Classe pai (superclasse)
class Animal {
    protected $nome;
    protected $idade;
    
    public function __construct($nome, $idade) {
        $this->nome = $nome;
        $this->idade = $idade;
    }
    
    public function comer() {
        return "{$this->nome} está comendo";
    }
    
    public function dormir() {
        return "{$this->nome} está dormindo";
    }
}

// Classe filha (subclasse) - herda de Animal
class Cachorro extends Animal {
    private $raca;
    
    public function __construct($nome, $idade, $raca) {
        parent::__construct($nome, $idade); // Chama construtor da classe pai
        $this->raca = $raca;
    }
    
    // Método específico da classe Cachorro
    public function latir() {
        return "{$this->nome} está latindo: Au au!";
    }
    
    // Sobrescrita de método (Override)
    public function comer() {
        return "{$this->nome} está comendo ração";
    }
}

class Gato extends Animal {
    public function miar() {
        return "{$this->nome} está miando: Miau!";
    }
}

$rex = new Cachorro("Rex", 5, "Labrador");
echo $rex->latir();
echo $rex->comer(); // Usa método sobrescrito
echo $rex->dormir(); // Usa método herdado

$felix = new Gato("Felix", 3);
echo $felix->miar();
?>
```

### 4. Polimorfismo

```php
<?php
// Interface - contrato que classes devem seguir
interface Pagavel {
    public function calcularPagamento();
}

class Funcionario implements Pagavel {
    protected $nome;
    protected $salario;
    
    public function __construct($nome, $salario) {
        $this->nome = $nome;
        $this->salario = $salario;
    }
    
    public function calcularPagamento() {
        return $this->salario;
    }
}

class Freelancer implements Pagavel {
    private $nome;
    private $valorHora;
    private $horasTrabalhadas;
    
    public function __construct($nome, $valorHora, $horasTrabalhadas) {
        $this->nome = $nome;
        $this->valorHora = $valorHora;
        $this->horasTrabalhadas = $horasTrabalhadas;
    }
    
    public function calcularPagamento() {
        return $this->valorHora * $this->horasTrabalhadas;
    }
}

// Polimorfismo em ação
function processarPagamento(Pagavel $pessoa) {
    echo "Pagamento: R$ " . $pessoa->calcularPagamento();
}

$func = new Funcionario("João", 5000);
$free = new Freelancer("Maria", 100, 80);

processarPagamento($func); // R$ 5000
processarPagamento($free); // R$ 8000
?>
```

### 5. Classes Abstratas

```php
<?php
// Classe abstrata - não pode ser instanciada diretamente
abstract class FormaGeometrica {
    protected $cor;
    
    public function __construct($cor) {
        $this->cor = $cor;
    }
    
    // Método abstrato - deve ser implementado nas classes filhas
    abstract public function calcularArea();
    
    // Método concreto - pode ser usado pelas classes filhas
    public function getCor() {
        return $this->cor;
    }
}

class Circulo extends FormaGeometrica {
    private $raio;
    
    public function __construct($cor, $raio) {
        parent::__construct($cor);
        $this->raio = $raio;
    }
    
    public function calcularArea() {
        return pi() * pow($this->raio, 2);
    }
}

class Retangulo extends FormaGeometrica {
    private $largura;
    private $altura;
    
    public function __construct($cor, $largura, $altura) {
        parent::__construct($cor);
        $this->largura = $largura;
        $this->altura = $altura;
    }
    
    public function calcularArea() {
        return $this->largura * $this->altura;
    }
}

$circulo = new Circulo("vermelho", 5);
echo $circulo->calcularArea(); // 78.54

$retangulo = new Retangulo("azul", 10, 5);
echo $retangulo->calcularArea(); // 50
?>
```

### 6. Métodos e Propriedades Estáticas

```php
<?php
class Matematica {
    public static $pi = 3.14159;
    
    public static function somar($a, $b) {
        return $a + $b;
    }
    
    public static function areaCirculo($raio) {
        return self::$pi * pow($raio, 2);
    }
}

// Acessando sem criar objeto
echo Matematica::somar(5, 3); // 8
echo Matematica::$pi; // 3.14159
echo Matematica::areaCirculo(10);
?>
```

### 7. Namespaces (Organização de código)

```php
<?php
namespace App\Models;

class Usuario {
    private $nome;
}

namespace App\Controllers;

class UsuarioController {
    public function criar() {
        $usuario = new \App\Models\Usuario();
    }
}

// Usando 'use' para simplificar
use App\Models\Usuario;

$user = new Usuario();
?>
```

## Conceitos-Chave da POO

- **Classe**: Modelo/template para criar objetos
- **Objeto**: Instância de uma classe
- **Encapsulamento**: Proteção de dados usando public, private, protected
- **Herança**: Reutilização de código entre classes relacionadas
- **Polimorfismo**: Capacidade de usar objetos diferentes através da mesma interface
- **Abstração**: Ocultar complexidade e mostrar apenas o necessário

A POO em PHP permite criar código mais organizado, reutilizável e fácil de manter, sendo fundamental para desenvolvimento de aplicações modernas com frameworks como Laravel, Symfony e outros.