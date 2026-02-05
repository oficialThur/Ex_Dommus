# Reajuste de preços de imóveis usando closure em PHP

Implemente um script PHP <strong> reajusta.php </strong> capaz de aplicar um reajuste percentual sobre os preços de uma lista de imóveis.
A lista será fornecida como uma matriz (array multidimensional) enviada por <strong> POST </strong> em formato JSON, junto com um <strong> percentual de reajuste positivo </strong>.

Cada linha da matriz representa um imóvel com os seguintes campos: 

    ** id ** — inteiro

    ** descricao ** — texto curto

    ** preco ** — número real

    ** disponibilidade **  — string contendo ** DISPONIVEL ** ou ** VENDIDO **

## Requisitos do script

    * Ler os dados enviados por POST:

        - matriz (JSON contendo o array de imóveis)

        - percentual (valor numérico positivo)
    
    * Criar uma closure que:

        Receba uma linha da matriz (um imóvel) e o percentual

        Aplique o reajuste somente se:

            - o percentual for positivo

            - a disponibilidade do imóvel for DISPONIVEL

        Retorne o array da linha atualizado (incluindo preço antigo e novo)

    * Processar toda a matriz usando a closure.

    * Exibir a listagem resultante contendo:

        - ID

        - Descrição

        - Preço antigo

        - Preço novo (apenas se foi reajustado)

        - Disponibilidade

## Mock da requisição cURL

O exemplo abaixo envia a matriz e o percentual por POST:

```json
    curl --location 'http://localhost/reajuste.php' \
    --form 'percentual="8"' \
    --form 'matriz="[
        {
            \"id\": 1,
            \"descricao\": \"Apartamento 80m² Centro\",
            \"preco\": 350000,
            \"disponibilidade\": \"DISPONIVEL\"
        },
        {
            \"id\": 2,
            \"descricao\": \"Casa 120m² Bairro Verde\",
            \"preco\": 480000,
            \"disponibilidade\": \"VENDIDO\"
        },
        {
            \"id\": 3,
            \"descricao\": \"Kitnet 30m²\",
            \"preco\": 150000,
            \"disponibilidade\": \"DISPONIVEL\"
        }
    ]"'
```

## Saída esperada (exemplo)

```json
    [
        {
            "id": 1,
            "descricao": "Apartamento 80m² Centro",
            "preco": 350000,
            "disponibilidade": "DISPONIVEL",
            "preco_novo": 378000,
            "preco_antigo": 350000
        },
        {
            "id": 2,
            "descricao": "Casa 120m² Bairro Verde",
            "preco": 480000,
            "disponibilidade": "VENDIDO",
            "preco_antigo": 480000
        },
        {
            "id": 3,
            "descricao": "Kitnet 30m²",
            "preco": 150000,
            "disponibilidade": "DISPONIVEL",
            "preco_novo": 162000,
            "preco_antigo": 150000
        }
    ]
```
# rode o ex no seguinte diretorio: 

## cd /home/artur/Dommus/trilha-treinamento/projectPasso2Php/reajusteDePreços/ php -S localhost:8080


