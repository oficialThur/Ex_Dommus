
#  Exercício 

## Descrição: 

Devo interpretar o dominio de locação imobiliarias e transformar esseas informações em artefatos de **analise orientada a objetos**.
Mas primeiramente tenho que elaborar uma descrição clara do domínio, identificando requisitos **funcionais, não funcionais e os principais elementos envolvidos no processo de locação**. Em seguida tenho que realizar uma análise textual do minicase para extrair os **casos de uso relevantes, listando atores, objetivos e principais fluxos de cada caso de uso**. A partir dessa análise tenho que deriva um conjunto de classes que representem adequadamente o domínio, definindo responsabilidades com foco em coesão e baixo acoplamento. Por fim devo organizar as classes resultantes em um **diagrama simples de classes orientado ao modelo MVC**, separando nitidamente as responsabilidades entre Model, View e Controller.


## Minicase — Sistema de Gestão de Locação Imobiliária: 

A Imobiliária Dommus deseja um sistema simples para gerenciar locações de imóveis residenciais. Os clientes podem alugar imóveis disponíveis, e cada contrato deve registrar datas de início e fim, valor mensal, responsável pelo pagamento e situação (ativo, encerrado, inadimplente). Os imóveis possuem endereço, tipo (casa, apartamento, kitnet), número de quartos, valor de locação sugerido e status (disponível, alugado, em manutenção). A imobiliária precisa registrar também proprietários dos imóveis, incluindo nome, telefone e percentual de comissão. Cada imóvel pertence a um proprietário. Os atendentes da imobiliária devem cadastrar clientes, cadastrar imóveis, registrar novos contratos de locação, atualizar situação de contratos e gerar uma listagem de contratos ativos.

# fontes para o auxilio da confecção do exercicio: 

- Modelo de Domínio [(guia.dev)](https://guia.dev/pt/pillars/business/domain-model.html)
- Domain-Driven Design (DDD): Um Resumo [(Engenharia de Software Moderna)](https://engsoftmoderna.info/artigos/ddd.html)
- Introdução à Engenharia de Requisitos - até Validação [(DevMedia)](https://www.devmedia.com.br/introducao-a-engenharia-de-requisitos/8034)
- Requisitos e Casos de Uso - até seção 3.2 e seção 3.4, respectivamente [(Engenharia de Software Moderna)](https://engsoftmoderna.info/cap3.html)
- Modelando Sistemas em UML - Casos de Uso ([Macoratti](https://www.macoratti.net/net_uml2.htm))
- Modelagem de classes estática: Conhecendo a análise textual – ver sessão Análise textual [Devmedia](https://www.devmedia.com.br/modelagem-de-classes-estatica-conhecendo-a-analise-textual/32036)
- O que é UML e Diagramas de Caso de Uso: Introdução Prática à UML [DevMedia](https://www.devmedia.com.br/o-que-e-uml-e-diagramas-de-caso-de-uso-introducao-pratica-a-uml/23408)
- O Padrão de Arquitetura MVC: Estruturando Aplicações Web de Forma Eficiente [Medium](https://medium.com/@gabrielequevedo/model-view-controller-mvc-316fbc169a5)
- O Maior Desafio de Trabalhar com o Padrão MVC: Separação de Responsabilidades e Desacoplamento [dio](https://www.dio.me/articles/o-maior-desafio-de-trabalhar-com-o-padrao-mvc-separacao-de-responsabilidades-e-desacoplamento-df23332c7aa1)
- Visão geral de como converter um caso de uso em diagrama de classes + arquitetura MVC [Visual Paradigm](https://guides.visual-paradigm.com/from-use-case-to-mvc-framework-a-guide-object-oriented-system-development/)



