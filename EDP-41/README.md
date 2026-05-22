
# app 

devo desenvolver uma aplicação, **aplicação web responsiva** utilizando **AngularJS 1.7.8** e **Bootstrap 4**, cujo objetivo e **listar e filtrar naves do universo Star Wars**.

## E Necessario utilizar: 
- Bootstrap 4
- AngularJS 1.7.8
- API a ser consumida: 
    https://swapi.info/api/starships

## Descrição da aplicação:

Este aplicação tem como foco avaliar a minha capacidade de **controlar o DOM com AngularJS**, estruturar a aplicação seguindo uma **arquitetura baseada em componentes**, compreender o funcionamento de **scope e rootScope**, além de aplicar corretamente **services, diretivas customizadas, comunicação entre componentes e consumo de API** em um cenário típico de **sistemas legados**.

### layout:

A aplicação deve conter uma página principal com:

- Listagem de Naves

    Ao carregar a aplicação, todas as naves devem ser buscadas automaticamente via API.

    Cada nave deve ser exibida em um **card do Bootstrap 4**, com informações relevantes (nome, classe, custo, capacidade de carga, fabricante).

    Enquanto os dados estiverem sendo carregados, deve ser exibido um **alert do Bootstrap** informando o estado de carregamento, controlado via AngularJS (ng-if ou ng-show).

- Modal de Filtros

    A aplicação deve possuir um **modal de filtros**, implementado como um **component do AngularJS**.
    Os filtros disponíveis devem ser:
        **Classe**: Select com as opções distintas de starship_class retornadas pela API
        **Custo**: Dois inputs numéricos (Inicial e Final), baseados em cost_in_credits
        **Capacidade de Carga**: Dois inputs numéricos (Inicial e Final), baseados em cargo_capacity
        **Nome**: Input de texto que filtre naves cujo atributo name contenha o texto informado
        **Fabricante**: Input de texto que filtre naves cujo atributo manufacturer contenha o texto informado
    Ao aplicar os filtros, as naves que **não se enquadrarem** devem ser ocultadas dinamicamente.
    Caso **nenhum filtro esteja informado**, todas as naves devem ser exibidas novamente.
    O modal deve ser aberto por evento

## Requisitos técnicos obrigatórios da aplicação:

- Deve consumir a API pública:
**https://swapi.info/api/starships**
- Utilizar **AngularJS 1.7.8**
- layout com **Bootstrap 4**
- Estruturar a aplicação com **modules** bem definidos
- Criar um **service** responsável por **abstrair todas as chamadas à API**, utilizando $http e $q
- O **card de nave** deve ser implementado como um **component** do, utilizando **one-way binding (<)**
- O **modal de filtros** deve ser implementado como um **component**
- Criar uma **diretiva customizada de atributo** aplicada ao **select de classe** (ex.: para normalização de valores, observação de mudanças ou enriquecimento de comportamento)
- Utilizar **$rootScope** para:
    Compartilhar estado global (ex.: filtros aplicados)
    Ou disparar eventos usando $broadcast / $emit para comunicação entre componentes
- Utilizar corretamente:
    ng-if e ng-show
    Watchers (com atenção a impacto em performance)
    Ciclo de digestão
Aplicar **seginjeção de dependências** corretamente em controllers, services, components e diretivas
Uso consciente de **filters** (nativos ou customizados), sem comprometer performance
Os componentes não podem manipular dados em escopos mais altos




