# 1 – Script de Cálculo com Dois Operandos
Crie um script PHP chamado calculadora.php que execute operações aritméticas entre dois operandos recebidos por POST, retornando o resultado no formato JSON. O script deverá utilizar superglobais, estrutura de decisão, constantes, tipos numéricos e funções.

Requisitos técnicos
## A) Entrada – via POST (application/json)
O script deverá receber um JSON com os seguintes campos:

{
  "esquerda": 10,
  "direita": 5,
  "operacao": "SOMA"
}

## B) Operações suportadas
As operações devem ser definidas por constantes, representando um "enum":

const SOMA = 'SOMA';
const SUBTRACAO = 'SUBTRACAO';
const MULTIPLICACAO = 'MULTIPLICACAO';
const DIVISAO = 'DIVISAO';
 
## C) Regras do cálculo
** O script deverá validar:

* que os operandos existem;

* que são numéricos;

* que a operação é válida;

* divisão por zero deve retornar erro apropriado.

** A operação deverá ser executada usando uma estrutura de controle.

** O cálculo deve ser feito em uma função chamada calcular() que recebe os parâmetros e ** retorna o resultado.

## D) Saída – JSON com o resultado
O script deve retornar um JSON no seguinte formato:

{
  "entrada": {
    "esquerda": 10,
    "direita": 5,
    "operacao": "SOMA"
  },
  "resultado": 15,
  "tipo_resultado": "integer"
}
Caso ocorra erro, retornar:




{
  "erro": "Mensagem explicativa do erro"
}
A seguir está o exercício totalmente adaptado para PHP, seguindo o mesmo padrão do exercício anterior, incluindo:

https://duvida.dommus.com.br/link/451#bkmrk-enunciado-claro-requ
 
Enunciado claro

Requisitos técnicos específicos

Uso de closure para aplicar o reajuste

Recebimento da matriz e do percentual via POST

Mock da requisição em cURL

 const SOMA = 'SOMA';
 const SUBTRACAO = 'SUBTRACAO';
 const MULTIPLICACAO = 'MULTIPLICACAO';
 const DIVISAO = 'DIVISAO';

 function calcular(float $num1, float $num2, string $operacao): float
 {
     switch ($operacao) {
         case SOMA:
             return $num1 + $num2;
         case SUBTRACAO:
             return $num1 - $num2;
         case MULTIPLICACAO:
             return $num1 * $num2;
         case DIVISAO:
             if ($num2 == 0) {
                 throw new DivisionByZeroError('Não é possível dividir por zero.');
             }
             return $num1 / $num2;
         default:
             throw new InvalidArgumentException('Operação inválida.');
     }
 }

 // Verifica se o número correto de argumentos foi passado
 if ($argc !== 4) {
     echo json_encode(['erro' => 'Uso: php calculadora.php <numero1> <OPERACAO> <numero2>']);
     exit(1); // Encerra o script com um código de erro
 }

 // Pega os argumentos da linha de comando
 $numero1 = (float)$argv[1];
 $operacao = $argv[2];
 $numero2 = (float)$argv[3];

 $resultado = [];

 try {
     $valorCalculado = calcular($numero1, $numero2, $operacao);
     $resultado = [
         'numero1' => $numero1,
         'operacao' => $operacao,
         'numero2' => $numero2,
         'resultado' => $valorCalculado
     ];
 } catch (Exception $e) {
     $resultado['erro'] = $e->getMessage();
 }

 echo json_encode($resultado, JSON_PRETTY_PRINT);