# app

## Exercício:

Eu Devo desenvolver a **interface de uma aplicação SPA em React.js**, para demonstra a minha capacidade de estruturar componentes, gerenciar estado, navegação, formulario, performace e iintegração de API, respeitando rigorosamente as regras de negócio descritas abaixo.

## Descrição da Aplicação:

A aplicação deve iniciar exibindo uma **tela inicial** contendo um **texto de lorem ipsum aleatório**. A partir dela, o usuário deve conseguir navegar para a **tela de Imóveis**, responsável por todo o gerenciamento da entidade **Imóvel**.

A aplicação **deve ser uma SPA**, utilizando **React Router DOM** para navegação interna.
A **tela de Imóveis (Unidades) deve ser carregada via Lazy Load**, utilizando obrigatoriamente **React.lazy e Suspense**, exibindo um fallback visual durante o carregamento.

### Requisitos Técnicos Obrigatórios

- Usar sua **api feita com lumen**

- Utilizar **ReactJS** com **Yarn** como gerenciador exclusivo de dependências

- Navegação com **React Router DOM**

- Lazy Load com **React.lazy + Suspense**

- Chamadas HTTP **encapsuladas em um service**, abstraindo o uso do **Axios**

- Exibir **feedback visual de carregamento e erro** durante chamadas de API

- Utilizar **Context API** para gerenciamento da lista de imóveis

- Aplicar **memoização de componentes** (React.memo, useMemo, useCallback) sempre que adequado

- Utilizar **React Hook Form** para formulários (sem estado local)

- Uso de **modal controlado por** useImperativeHandle

- Respeitar integralmente as **regras de negócio no frontend**

- Utilizar **React DevTools** como apoio ao desenvolvimento

### UI – Funcionalidades Obrigatórias

#### 1. Tela Inicial
- Exibir um texto de lorem ipsum aleatório
- Disponibilizar navegação para a tela de imóveis

#### 2. Tela de Imóveis (Lazy Loaded)

##### Listagem
 
- Exibir lista paginada de imóveis ativos

- Mostrar:
    - Total de imóveis listados
    - Somatório total dos preços
- Permitir navegação entre páginas
- Atualizar dinamicamente os totais conforme filtros

##### Filtros

- Filtrar por:
    - Faixa de preço (mínimo e máximo)
    - Disponibilidade (DISPONIVEL | VENDIDO)
- Aplicar filtros via **query params**
- Recarregar lista, totais e paginação conforme filtros

#### 3. Cadastro de Imóvel
 
- Formulário contido em um **modal**

- Modal deve ser aberto via **useImperativeHandle**

- O formulário:
    - **Não pode possuir estado próprio**
    - Deve utilizar **React Hook Form**
    - Deve aplicar **validações e máscaras**
    - Deve possuir os campos nome, preço e descrição.
- Ao cadastrar:
    - A lista deve ser atualizada imediatamente
    - O novo imóvel deve aparecer respeitando os filtros ativos

#### 4. Edição de Imóvel

- Permitir edição de:
    - Descrição
    - Preço **somente se disponibilidade = DISPONIVEL**
    - Disponibilidade (DISPONIVEL ou VENDIDO)
- A regra deve ser garantida no frontend
- O formulário deve ser preenchido com os valores atuais para o imóvel
- Deve ser reutilizado o formulário de cadastro
- Persistir alterações e refletir imediatamente na lista

#### 6. Reajuste de Preço em Massa

- Interface para aplicar reajuste percentual
- Regras obrigatórias:
    - Percentual positivo
    - Aplicar apenas nos imóveis visíveis na lista atual
    - Ignorar imóveis com disponibilidade = VENDIDO
- A lógica deve estar:
    - Implementada no UnidadeService
    - Acessada via uma interface ReajustePrecoInterface
- Atualizar valores na UI após persistência

#### 7. Exportação de Imóveis (CSV)

- Interface para solicitar exportação
- Comportamento esperado no frontend:
    - Acionar endpoint dedicado
    - Ignorar filtros e paginação    
    - Baixar arquivo CSV
- Exibir feedback visual durante o processo

### Domínio da Aplicação – Imóvel

- id (integer, auto incremental)
- descricao (string, até 255 caracteres)
- preco (decimal)
- disponibilidade (DISPONIVEL | VENDIDO)
- ativo (boolean ou enum 0/1 – soft delete)
    - Não exposto pela API
    - Apenas ativos devem ser considerados
