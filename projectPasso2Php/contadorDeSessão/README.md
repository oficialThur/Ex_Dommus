# Contador de Sessão via GET

### Descrição:
Crie um script PHP contador.php que utilize <strong>sessão</strong> para armazenar um contador. A cada requisição feita via <strong>GET</strong>, o script deve:

    1. Iniciar a sessão.
    2. Verificar se a variável contador existe na sessão:
        Caso não exista, inicializá-la com 0.
    3. Incrementar o valor de contador em 1.
    4. Retornar o novo valor no corpo da resposta (em texto simples ou JSON — escolha livre).

O script deve ser invocado via GET e não deve exigir parâmetros adicionais.

## Mock da Requisição (cURL)
```bash
    curl --location --request GET 'http://localhost/contador_sessao.php'
```
    