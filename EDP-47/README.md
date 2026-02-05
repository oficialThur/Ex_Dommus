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


📋 DIVISÃO DO EXERCÍCIO EM ETAPAS
ETAPA 1: Configuração Inicial do Projeto
Passos:

Instalar o Lumen via Composer

bash   composer create-project --prefer-dist laravel/lumen imovel-app
   cd imovel-app
```

2. Configurar o arquivo `.env`
   - Copiar `.env.example` para `.env`
   - Configurar credenciais do banco de dados
   - Adicionar variáveis para Basic Auth:
```
     API_USERNAME=admin
     API_PASSWORD=secret123

Habilitar features no bootstrap/app.php

Descomentar $app->withFacades()
Descomentar $app->withEloquent()
Registrar providers necessários


Testar se o servidor sobe corretamente

bash   php -S localhost:8000 -t public

ETAPA 2: Banco de Dados - Migration e Model
Passos:

Criar a migration da tabela imoveis

bash   php artisan make:migration create_imoveis_table

Definir a estrutura da tabela na migration:

id (bigIncrements)
descricao (string, 255)
preco (decimal, 10, 2)
disponibilidade (enum: 'DISPONIVEL', 'VENDIDO')
ativo (boolean, default true)
timestamps


Executar a migration

bash   php artisan migrate

Criar o Model Imovel em app/Models/Imovel.php:

Definir $table = 'imoveis'
Definir $fillable (descricao, preco, disponibilidade, ativo)
Definir $hidden (ativo, created_at, updated_at)
Definir $casts (preco como decimal, ativo como boolean)

ETAPA 3: Implementar Soft Delete Manual
Passos:

Adicionar Query Scope no Model Imovel:

Criar scopeAtivos() que filtra apenas ativo = true


Criar método customizado de exclusão:

Sobrescrever ou criar método softDelete() que marca ativo = false


Aplicar o scope globalmente (opcional):

Criar Global Scope para sempre filtrar apenas ativos nas queries

ETAPA 4: Observer para Regras de Negócio
Passos:

Criar o Observer ImovelObserver

bash   php artisan make:observer ImovelObserver --model=Imovel

Implementar regra no método updating():

Verificar se o preço está sendo alterado
Se sim, verificar se disponibilidade == 'DISPONIVEL'
Se não estiver disponível, retornar false ou lançar exceção


Implementar regra no método deleting():

Verificar se disponibilidade == 'DISPONIVEL'
Se não estiver disponível, retornar false ou lançar exceção


Registrar o Observer no AppServiceProvider ou EventServiceProvider:

php   Imovel::observe(ImovelObserver::class);

ETAPA 5: Service e Interface para Reajuste de Preço
Passos:

Criar a interface app/Contracts/ReajustePrecoInterface.php:

php   interface ReajustePrecoInterface {
       public function aplicarReajuste(array $imoveis, float $percentual): int;
   }

Criar o serviço app/Services/UnidadeService.php:

Implementar ReajustePrecoInterface
Criar método aplicarReajuste() com a lógica:

Filtrar imóveis com disponibilidade DISPONIVEL
Aplicar fórmula: preco_novo = preco_atual + (preco_atual × percentual / 100)
Persistir alterações
Retornar quantidade de imóveis reajustados




Registrar no Service Container (AppServiceProvider):

php   $this->app->bind(
       \App\Contracts\ReajustePrecoInterface::class,
       \App\Services\UnidadeService::class
   );

ETAPA 6: JSON Resources
Passos:

Criar app/Http/Resources/ImovelResource.php:

Definir estrutura de retorno (id, descricao, preco, disponibilidade)
Não expor o campo ativo


Criar app/Http/Resources/ImovelCollection.php:

Adicionar metadados: quantidade total e somatório de preços
Estruturar paginação


Testar se as resources estão formatando corretamente


ETAPA 7: Middleware de Autenticação Basic Auth
Passos:

Criar middleware app/Http/Middleware/BasicAuthMiddleware.php:

Extrair header Authorization
Decodificar Base64
Comparar com credenciais do .env
Retornar 401 se inválido


Registrar o middleware no bootstrap/app.php:

php   $app->routeMiddleware([
       'auth.basic' => App\Http\Middleware\BasicAuthMiddleware::class,
   ]);

Aplicar o middleware nas rotas


ETAPA 8: Validação de Requisições
Passos:

Criar classes de validação ou usar validação inline:

StoreImovelRequest - validações para criação
UpdateImovelRequest - validações para atualização
ReajusteRequest - validação do percentual


Definir regras:

descricao: required, string, max:255
preco: required, numeric, min:0
disponibilidade: required, in:DISPONIVEL,VENDIDO
percentual: required, numeric, gt:0




ETAPA 9: Controller e Rotas CRUD
Passos:

Criar app/Http/Controllers/ImovelController.php
Implementar métodos:

index() - Listar com paginação, filtros, totais
store() - Criar imóvel
show() - Exibir um imóvel
update() - Atualizar imóvel
destroy() - Soft delete


Implementar filtros no index():

Query params: preco_min, preco_max, disponibilidade
Aplicar filtros usando Query Builder


Calcular metadados:

Quantidade total de imóveis
Somatório de preços


Definir rotas em routes/web.php:

php   $router->group(['prefix' => 'api', 'middleware' => 'auth.basic'], function () use ($router) {
       $router->get('imoveis', 'ImovelController@index');
       $router->post('imoveis', 'ImovelController@store');
       $router->get('imoveis/{id}', 'ImovelController@show');
       $router->put('imoveis/{id}', 'ImovelController@update');
       $router->delete('imoveis/{id}', 'ImovelController@destroy');
   });

ETAPA 10: Endpoint de Reajuste em Massa
Passos:

Adicionar método reajusteEmMassa() no ImovelController
Injetar ReajustePrecoInterface no controller via construtor
Implementar lógica:

Receber percentual via request
Validar percentual (deve ser positivo)
Buscar imóveis ativos com filtros aplicados (mesma lógica do index)
Chamar serviço de reajuste
Retornar quantidade de imóveis reajustados


Adicionar rota:

php   $router->post('imoveis/reajuste', 'ImovelController@reajusteEmMassa');

ETAPA 11: Exportação CSV com Streamed Response
Passos:

Criar método exportarCsv() no ImovelController
Implementar lógica:

Buscar todos os imóveis ativos (sem filtros, sem paginação)
Usar StreamedResponse
Gerar CSV linha por linha:

Header: ID, Descrição, Preço, Disponibilidade
Dados: iterar sobre imóveis e escrever no stream




Configurar headers HTTP:

php   'Content-Type' => 'text/csv',
   'Content-Disposition' => 'attachment; filename="imoveis.csv"'

Adicionar rota:

php   $router->get('imoveis/exportar', 'ImovelController@exportarCsv');

ETAPA 12: Testes e Refinamentos
Passos:

Testar todos os endpoints com ferramentas (Postman, Insomnia, curl):

Listar imóveis
Filtrar por preço e disponibilidade
Criar imóvel
Atualizar imóvel (testar regra do Observer)
Excluir imóvel (testar regra do Observer)
Reajuste em massa
Exportar CSV


Validar autenticação Basic Auth:

Testar com credenciais corretas
Testar com credenciais incorretas
Testar sem header Authorization


Validar regras de negócio:

Tentar alterar preço de imóvel VENDIDO (deve falhar)
Tentar excluir imóvel VENDIDO (deve falhar)
Verificar se soft delete funciona corretamente


Validar JSON Resources:

Campo ativo não deve aparecer nas respostas
Metadados (quantidade e somatório) devem estar corretos


Validar exportação CSV:

Arquivo deve baixar corretamente
Conteúdo deve estar formatado
Grandes volumes devem ser eficientes (testar com seed de muitos registros)




ETAPA 13: Documentação e Finalização
Passos:

Criar/atualizar README.md do projeto com:

Instruções de instalação
Configuração do .env
Como rodar migrations
Exemplos de uso dos endpoints


Adicionar collection do Postman/Insomnia (opcional)
Revisar código:

Nomenclaturas consistentes
Comentários onde necessário
Remover código desnecessário


Commit final e organização do repositório


🎯 Resumo das Etapas

✅ Configuração Inicial
✅ Migration e Model
✅ Soft Delete Manual
✅ Observer
✅ Service e Interface
✅ JSON Resources
✅ Basic Auth Middleware
✅ Validação
✅ Controller e Rotas CRUD
✅ Reajuste em Massa
✅ Exportação CSV
✅ Testes
✅ Documentação