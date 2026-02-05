# Criptografia de String e Retorno via Cookie

Crie um script PHP criptografa.php que receba uma string através da <strong>query string</strong>, criptografe esse valor utilizando <strong>OpenSSL</strong> e retorne o valor criptografado através de um <strong>cookie</strong>.

O script deve:

    1. Ler o parâmetro texto enviado via GET.

    2. Validar se o valor foi informado — caso não seja enviado, retornar mensagem de erro apropriada.

    3.Usar openssl_encrypt para criptografar o texto (o algoritmo pode ser definido como constante no script, como  por exemplo AES-256-CBC).

    4. Gerar uma chave e IV fixos apenas para fins de exercício (no mundo real usaria segredo seguro).

    5.Armazenar o texto criptografado em um cookie chamado texto_criptografado.

    6.Retornar para o usuário uma mensagem informando que o cookie foi definido.

## Mock da Requisição (cURL)
```bash
    curl --location --request GET 'http://localhost/criptografar.php?texto=mensagem_secreta'
```
