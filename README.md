# app 

## Exercício

Eu devo desenvolver uma **API RESTful** utilizando **Lumen** para gerenciar o domínio de **Imóveis**, aplicando boas práticas de arquitetura, validação, segurança básica e regras de negócio. Este teste tem como objetivo avaliar a minha capacidade de **estruturar uma API profissional**, utilizando corretamente **Lumen** **controllers, services, interfaces, service container, observers, migrations, Eloquent e JSON Resources**, em um cenário próximo ao encontrado em sistemas reais da software house.

## Requisitos
- A API deve ser protegida por **autorização básica (Basic Auth)**, lendo **login e senha a partir de variáveis de ambiente (.env)**
- **todas as entradas de requisição devem ser validadas**
- As respostas da API devem ser retornadas **exclusivamente através de JSON Resources**, garantindo padronização e isolamento da camada de apresentação.

## Domínio da Aplicação

### A aplicação deve gerenciar uma entidade chamada Imóvel, contendo os seguintes campos:

- id (integer, auto incremental)

- descricao (string, até 255 caracteres)

- preco (decimal)

- disponibilidade (enum: DISPONIVEL | VENDIDO)

- ativo (boolean ou enum 0 / 1)1
    Campo utilizado para **soft delete**
    **Não deve ser exposto nas respostas da API**
    Apenas imóveis com ativo
		= true devem ser considerados nas operações

## Requisitos Técnicos Obrigatórios

### Arquitetura e Infraestrutura

- Utilizar **Lumen**

- Criar **migration** para a entidade imoveis

- Utilizar **Eloquent ORM**

- Criar **Model Imovel**

- Criar **Observer** para o model Imovel
    O observer deve **impedir qualquer alteração de preço** caso o imóvel **não esteja com disponibilidade** DISPONIVEL
    O
            observer deve **impedir exclusão**
            caso o imóvel **não esteja com disponibilidade** DISPONIVEL

- Utilizar **JSON Resources** para todos os retornos

- Criar **Service e Interface** para regras de reajuste de preço
    Exemplo:
        ReajustePrecoInterface
        UnidadeService implementando essa interface

- Registrar a interface e sua implementação no **Service Container**

- Injetar o serviço **sempre pela interface**, nunca pela classe concreta

- Utilizar **validação de requisições** em todas as entradas

- Implementar **paginação**

- Utilizar **Query Builder / Scopes** para filtros

- Aplicar **soft delete manual** via campo ativo

- Implementar
	**exportação de imóveis em CSV utilizando Streamed Response**,
	garantindo eficiência de memória e escalabilidade para grandes
	volumes de dados.

## Casos de Uso Obrigatórios

### 1. Usuário lista os imóveis

**Objetivo**: Exibir a lista de imóveis ativos.

**Comportamento esperado:**

- Endpoint deve retornar uma **lista paginada**

- Listar apenas imóveis com ativo
	= true

- Retornar junto:
    Quantidade total de imóveis listados
    Somatório total dos preços dos imóveis listados

- Permitir navegação entre páginas

### 2. Usuário filtra imóveis por preço e disponibilidade

**Objetivo**: Permitir refinamento da listagem.

**Filtros permitidos:**

- Faixa de preço mínima e máxima

- Disponibilidade (DISPONIVEL ou VENDIDO)

**Comportamento esperado:**

- Aplicar filtros via query params

- Atualizar a lista, quantidade total e somatório de preços considerando apenas os filtros ativos

### 3. Usuário cadastra um imóvel

**Objetivo**: Criar um novo imóvel.

**Campos de entrada:**

- descrição
- preco
- disponibilidade

**Comportamento esperado:**

- Validar os dados de entrada

- Salvar com:
    ativo
            = true por padrão
    id gerado automaticamente

### 4. Usuário edita um imóvel    

**Objetivo**: Atualizar dados de um imóvel existente.

**Comportamento esperado:**

- Permitir alteração da descricao

- Permitir alteração do preco **apenas se a disponibilidade for** DISPONIVEL

- A regra deve ser garantida pelo **Observer**

- Persistir as alterações corretamente

### 5. Usuário exclui um imóvel (soft delete)

**Objetivo**: Remover logicamente um imóvel.

**Comportamento esperado:**

- Permitir exclusão **somente se o imóvel estiver** DISPONIVEL

- Exclusão deve:
    Marcar ativo
            = false

    Não remover o registro do banco
- O imóvel não deve:1
    Aparecer em listagens
    Ser considerado em totais e filtros

### 6. Usuário aplica reajuste de preço em massa

**Objetivo**: Aplicar reajuste percentual aos imóveis listados.

**Comportamento esperado:**

- Receber um percentual **positivo**

- Aplicar reajuste **somente aos imóveis visíveis na lista atual (filtros ativos)**

- Imóveis com disponibilidade
	= VENDIDO **não devem ser reajustados**

- Fórmula obrigatória:
```PHP
preco_novo = preco_atual + (preco_atual × percentual / 100)
```
- A lógica de reajuste deve estar:

- Implementada no UnidadeService

- Acessada via interface (ReajustePrecoInterface)

- Persistir os novos valores no banco

### 7. Usuário exporta imóveis em CSV

**Objetivo**:Permitir ao usuário exportar os imóveis ativos do sistema em formato **CSV**, de forma eficiente e escalável.

**Comportamento esperado:**

- O usuário poderá solicitar a exportação dos imóveis por meio de um endpoint dedicado.

- O sistema deve:
    Exportar **todos os imóveis ativos** (ativo
            = true)
    **Não aplicar filtros** (ignorar filtros de preço, disponibilidade ou paginação)
- O arquivo CSV deve conter, no mínimo, as seguintes colunas:
    ID
    Descrição
    Preço
    Disponibilidade
- O campo ativo **não deve** ser incluído no arquivo.

- A exportação deve ser realizada utilizando **Streamed Response**, evitando:
    Carregamento de todos os registros em memória
    Geração de arquivos temporários no servidor

- O endpoint deve:
    Retornar headers corretos para download (Content-Type, Content-Disposition)
    Gerar o conteúdo do CSV dinamicamente durante o streaming

- A resposta deve respeitar a **autorização básica** da aplicação.