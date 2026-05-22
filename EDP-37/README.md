
# Exencicio de Manipulação do DOM e Eventos com JQuery

Você deverá desenvolver **uma página web responsiva** utilizando **JavaScript com jQuery e Bootstrap 4**, cujo objetivo é **listar e filtrar naves do universo Star Wars**, consumindo dados da API pública disponível em:
https://swapi.info/api/starships

A página deverá, ao ser carregada, **buscar todas as naves via AJAX de baixo nível** ($.ajax) e renderizar dinamicamente no DOM **um card do Bootstrap 4 para cada nave**, exibindo informações relevantes (como nome, classe, fabricante, custo e capacidade de carga). Durante o carregamento inicial dos dados, deve ser exibido **um alert do Bootstrap** informando o estado de carregamento ao usuário, o qual deverá ser removido assim que os dados forem carregados e renderizados.

Além da listagem, a página deverá conter um **modal de filtros**, também construído com Bootstrap 4, que permita ao usuário aplicar os seguintes critérios sobre a lista já carregada no frontend (não é permitido refazer a requisição para filtrar):

- Classe: Select com todas as opções distintas de starship_class retornadas pela API

- Custo: Dois inputs numéricos (Inicial e Final), baseados no atributo cost_in_credits

- Capacidade de Carga: Dois inputs numéricos (Inicial e Final), baseados no atributo cargo_capacity

- Nome: Input de texto para filtrar naves cujo atributo name contenha o texto informado

- Fabricante: Input de texto para filtrar naves cujo atributo manufacturer contenha o texto informado

**Comportamento esperado:**



- Ao carregar a página, todas as naves devem ser exibidas em cards (https://getbootstrap.com/docs/4.6/components/card/).

- Enquanto as naves são carregadas, deve ser dado um feedback visual de carregamento usando componente alert (https://getbootstrap.com/docs/4.6/components/alerts/) do Bootstrap

- Ao aplicar os filtros, o modal deve ser fechado automáticamente. As naves que não se enquadrarem nos critérios devem ser ocultadas via manipulação de DOM, sem recarregar a página.

- Caso nenhum filtro esteja preenchido, todas as naves devem ser exibidas novamente.

- A aplicação deve funcionar corretamente em resoluções desktop e mobile.

**Regras obrigatórias do teste:**

- O consumo da API deve ser feito exclusivamente com $.ajax.

- Todos os eventos (clique, submit, change, etc.) devem ser manipulados via jQuery.

- Toda a manipulação do DOM (criação de cards, exibição/ocultação, leitura de inputs, atualização de classes e atributos) deve ser feita exclusivamente com jQuery.

- Não é permitido o uso de fetch, frameworks JS ou manipulação direta de DOM via APIs nativas (document.querySelector, etc.).


