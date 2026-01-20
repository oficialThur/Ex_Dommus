
# app 

devo desenvolver uma aplicação, **Single Page Application (SPA)** que tenha tema **“Visite o Espaço”**.

## E Necessario a utilizar: 
- Bootstrap 5 
- jQuery para: 
    Navegação interna
    Manipulação de DOM
    eventos e consumo de API
    AJAX de baixo nível ($.ajax)

- API a ser consumida: 
    https://swapi.info/api/planets/

## Descrição da layout da aplicação:

A aplicação deverá possuir um **menu superior fixo (Navbar) contendo os itens Início, Sobre, Destinos e Contato**, e a navegação entre essas seções deverá ocorrer sem recarregamento de página, **caracterizando o comportamento de uma (SPA)**. A troca de “páginas” deve ser feita por **manipulação dinâmica do DOM via jQuery**, controlada por eventos de clique no menu **(Navbar)**.

### A estrutura funcional da aplicação deve atender aos seguintes requisitos:

- Página Inicial (Início)
Deve conter um **banner principal (hero section/Header) abaixo do NAvebar** com chamada temática relacionada a viagens espaciais e um texto descritivo. Os textos podem ser **hardcoded** e gerados a partir do **Mussum Ipsum**,([o melhor lorem ipsum do mundis](https://mussumipsum.com/)).

- Página Sobre
Deve apresentar um texto institucional sobre a proposta fictícia da empresa de turismo espacial, também com conteúdo **hardcoded** e gerados a partir do **Mussum Ipsum**,([o melhor lorem ipsum do mundis](https://mussumipsum.com/)).
      
- Página Destinos
Deve consumir a API pública:
**https://swapi.info/api/planets/**
Os planetas devem ser carregados via **AJAX de baixo nível ($.ajax)** e exibidos dinamicamente no DOM, preferencialmente em cards do **Bootstrap 5**, contendo informações relevantes do planeta (nome, clima, terreno, população, etc.).
Enquanto os dados estiverem sendo carregados, deve ser exibido um **alert do Bootstrap** indicando o estado de carregamento. Após o carregamento, o alerta deve ser removido.

- Página Contato
Deve conter um formulário de contato funcional, implementado com jQuery, contendo:

    Nome
    E-mail
    Assunto
    Mensagem
    O formulário deve possuir:
        Validação de campos obrigatórios
        Validação básica de e-mail
        Feedback visual ao usuário (sucesso, erro, loading) usando componentes do Bootstrap 4
        Simulação de envio (não é necessário backend)

## Requisitos técnicos obrigatórios da aplicação:

- Aplicação no formato **(SPA)**, sem reload de página

- Layout responsivo utilizando **Bootstrap 5**

- Consumo de API e requisições **exclusivamente com $.ajax**

- Todos os eventos devem ser manipulados via **jQuery**

- Toda a manipulação do DOM deve ser feita **exclusivamente com jQuery**

- Não é permitido o uso de frameworks JS modernos ou APIs nativas de DOM diretamente

- Código organizado, legível e com separação básica de responsabilidades


