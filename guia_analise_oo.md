# Guia Completo: Análise Orientada a Objetos
## Sistema de Gestão de Locação Imobiliária - Imobiliária Dommus

---

## ETAPA 1: COMPREENSÃO DO DOMÍNIO E LEVANTAMENTO DE REQUISITOS

### O que é Modelo de Domínio?
Segundo o DDD (Domain-Driven Design), o modelo de domínio é **a representação dos conceitos do negócio** e suas relações. É o "coração do software" - se você não entender o domínio (negócio), o software não resolverá os problemas reais.

### 1.1 Descrição Clara do Domínio

**Domínio: Gestão de Locação Imobiliária**

A Imobiliária Dommus trabalha como intermediária entre proprietários de imóveis e clientes interessados em alugar. O processo envolve:
- Cadastro de imóveis disponíveis para locação
- Registro de proprietários e clientes
- Formalização de contratos de locação
- Acompanhamento da situação dos contratos
- Gestão da disponibilidade dos imóveis

### 1.2 Requisitos Funcionais (O que o sistema DEVE fazer)

**RF01** - Cadastrar Clientes
- Sistema deve permitir registro de dados de clientes interessados em alugar imóveis

**RF02** - Cadastrar Imóveis
- Sistema deve permitir registro de imóveis com suas características

**RF03** - Cadastrar Proprietários
- Sistema deve manter dados dos donos dos imóveis

**RF04** - Registrar Contratos de Locação
- Sistema deve formalizar contratos entre clientes e proprietários

**RF05** - Atualizar Situação de Contratos
- Sistema deve permitir mudança de status (ativo → encerrado, ativo → inadimplente, etc.)

**RF06** - Gerar Listagem de Contratos Ativos
- Sistema deve exibir relatório com contratos em andamento

**RF07** - Consultar Imóveis Disponíveis
- Sistema deve permitir busca por imóveis que podem ser alugados

### 1.3 Requisitos Não-Funcionais (COMO deve funcionar)

**RNF01** - Usabilidade
- Interface deve ser intuitiva para atendentes com conhecimento básico em informática

**RNF02** - Confiabilidade
- Dados de contratos não podem ser perdidos (críticos para o negócio)

**RNF03** - Desempenho
- Consultas devem retornar resultados em menos de 3 segundos

**RNF04** - Manutenibilidade
- Código deve ser organizado para facilitar futuras expansões

**RNF05** - Integridade dos Dados
- Sistema deve garantir consistência (ex: imóvel não pode estar "disponível" e "alugado" ao mesmo tempo)

### 1.4 Principais Elementos do Domínio

**Entidades Identificadas:**
- Cliente
- Imóvel
- Proprietário
- Contrato de Locação
- Atendente

**Conceitos Importantes:**
- Status do Imóvel (disponível, alugado, em manutenção)
- Situação do Contrato (ativo, encerrado, inadimplente)
- Tipo de Imóvel (casa, apartamento, kitnet)

---

## ETAPA 2: ANÁLISE TEXTUAL E EXTRAÇÃO DE CASOS DE USO

### 2.1 Técnica de Análise Textual

**Como funciona:**
- **SUBSTANTIVOS** = possíveis CLASSES ou ATRIBUTOS
- **VERBOS** = possíveis MÉTODOS ou CASOS DE USO
- **ADJETIVOS** = possíveis ATRIBUTOS ou ESTADOS

### 2.2 Aplicando Análise Textual no Minicase

**Texto original analisado:**

> "A Imobiliária Dommus deseja um sistema simples para gerenciar **locações** de **imóveis** residenciais. Os **clientes** podem **alugar** **imóveis** disponíveis, e cada **contrato** deve **registrar** **datas** de início e fim, **valor mensal**, **responsável** pelo pagamento e **situação** (ativo, encerrado, inadimplente)."

**Substantivos (Candidatos a Classes/Atributos):**
- Imobiliária, sistema, locação, imóvel, cliente, contrato, data, valor mensal, responsável, situação, endereço, tipo, quartos, proprietário, nome, telefone, comissão, atendente

**Verbos (Candidatos a Métodos/Casos de Uso):**
- gerenciar, alugar, registrar, cadastrar, atualizar, gerar

### 2.3 Casos de Uso Identificados

#### Atores do Sistema:
1. **Atendente** - funcionário da imobiliária (ator principal)
2. **Sistema** - próprio sistema (ator secundário para ações automáticas)

#### UC01 - Cadastrar Cliente
**Ator:** Atendente  
**Objetivo:** Registrar novo cliente no sistema  
**Fluxo Principal:**
1. Atendente seleciona opção "Cadastrar Cliente"
2. Sistema exibe formulário de cadastro
3. Atendente informa dados do cliente (nome, CPF, telefone, email)
4. Sistema valida dados
5. Sistema confirma cadastro
6. Caso de uso encerrado

**Extensões:**
- 4a. Se CPF já cadastrado → Sistema informa erro

#### UC02 - Cadastrar Imóvel
**Ator:** Atendente  
**Objetivo:** Registrar novo imóvel para locação  
**Fluxo Principal:**
1. Atendente seleciona "Cadastrar Imóvel"
2. Sistema exibe formulário
3. Atendente informa: endereço, tipo, quartos, valor sugerido, proprietário
4. Sistema valida dados
5. Sistema define status como "disponível"
6. Sistema confirma cadastro

**Extensões:**
- 3a. Se proprietário não existe → Sistema solicita cadastro do proprietário primeiro

#### UC03 - Registrar Contrato de Locação
**Ator:** Atendente  
**Objetivo:** Formalizar aluguel de imóvel  
**Fluxo Principal:**
1. Atendente seleciona "Registrar Contrato"
2. Sistema exibe lista de imóveis disponíveis
3. Atendente seleciona imóvel
4. Atendente informa cliente, data início, data fim, valor mensal
5. Sistema calcula comissão do proprietário
6. Sistema marca imóvel como "alugado"
7. Sistema define situação como "ativo"
8. Sistema confirma contrato

**Extensões:**
- 2a. Se não há imóveis disponíveis → Sistema informa
- 4a. Se cliente não cadastrado → Sistema solicita cadastro

#### UC04 - Atualizar Situação do Contrato
**Ator:** Atendente  
**Objetivo:** Modificar status de contrato existente  
**Fluxo Principal:**
1. Atendente busca contrato
2. Sistema exibe dados do contrato
3. Atendente seleciona nova situação (inadimplente/encerrado)
4. Sistema valida mudança
5. Se situação = "encerrado" → Sistema marca imóvel como "disponível"
6. Sistema confirma atualização

#### UC05 - Gerar Listagem de Contratos Ativos
**Ator:** Atendente  
**Objetivo:** Visualizar contratos em andamento  
**Fluxo Principal:**
1. Atendente seleciona "Listar Contratos Ativos"
2. Sistema busca contratos com situação = "ativo"
3. Sistema exibe lista com: imóvel, cliente, valor, datas
4. Caso de uso encerrado

**Extensões:**
- 2a. Se não há contratos ativos → Sistema informa

---

## ETAPA 3: DERIVAÇÃO DAS CLASSES COM COESÃO E BAIXO ACOPLAMENTO

### 3.1 Conceitos Importantes

**Coesão:** Uma classe deve ter responsabilidades bem definidas e relacionadas.
- **Alta coesão** = classe focada em um único propósito
- Exemplo BOM: classe `Contrato` só gerencia dados e regras de contratos

**Acoplamento:** Grau de dependência entre classes.
- **Baixo acoplamento** = classes independentes, fáceis de modificar
- Use interfaces e não dependa de implementações concretas

### 3.2 Classes Identificadas

#### Classe: Cliente
**Responsabilidades:**
- Representar pessoa que aluga imóveis
- Manter dados cadastrais

**Atributos:**
- id: int
- nome: String
- cpf: String
- telefone: String
- email: String

**Métodos:**
- validarCPF(): boolean
- atualizarDados(...)

---

#### Classe: Imovel
**Responsabilidades:**
- Representar imóvel disponível para locação
- Gerenciar status de disponibilidade

**Atributos:**
- id: int
- endereco: String
- tipo: TipoImovel (enum: CASA, APARTAMENTO, KITNET)
- numeroQuartos: int
- valorSugerido: double
- status: StatusImovel (enum: DISPONIVEL, ALUGADO, EM_MANUTENCAO)
- proprietario: Proprietario

**Métodos:**
- marcarComoAlugado()
- marcarComoDisponivel()
- isDisponivel(): boolean

---

#### Classe: Proprietario
**Responsabilidades:**
- Representar dono de imóveis
- Calcular comissão

**Atributos:**
- id: int
- nome: String
- telefone: String
- percentualComissao: double

**Métodos:**
- calcularComissao(valorAluguel: double): double

---

#### Classe: Contrato
**Responsabilidades:**
- Formalizar locação entre cliente e imóvel
- Gerenciar situação do contrato

**Atributos:**
- id: int
- dataInicio: Date
- dataFim: Date
- valorMensal: double
- situacao: SituacaoContrato (enum: ATIVO, ENCERRADO, INADIMPLENTE)
- cliente: Cliente
- imovel: Imovel

**Métodos:**
- encerrar()
- marcarInadimplente()
- isAtivo(): boolean
- calcularComissaoProprietario(): double

---

#### Classe: Atendente
**Responsabilidades:**
- Representar funcionário que opera o sistema

**Atributos:**
- id: int
- nome: String
- login: String

**Métodos:**
- autenticar(): boolean

---

## ETAPA 4: ORGANIZAÇÃO NO PADRÃO MVC

### 4.1 O que é MVC?

**Model-View-Controller** é um padrão arquitetural que separa:
- **Model** (Modelo) = lógica de negócio e dados
- **View** (Visão) = interface com usuário
- **Controller** (Controlador) = coordena Model e View

### 4.2 Separação das Classes no MVC

#### MODEL (Camada de Negócio/Dados)

**Classes de Domínio:**
- `Cliente`
- `Imovel`
- `Proprietario`
- `Contrato`
- `Atendente`

**Enumerações:**
- `TipoImovel`
- `StatusImovel`
- `SituacaoContrato`

**Repositórios (acesso a dados):**
- `ClienteRepository`
- `ImovelRepository`
- `ProprietarioRepository`
- `ContratoRepository`

**Serviços (regras de negócio complexas):**
- `LocacaoService` → orquestra criação de contratos

---

#### VIEW (Camada de Apresentação)

**Telas/Formulários:**
- `FormCadastroCliente`
- `FormCadastroImovel`
- `FormRegistroContrato`
- `ListaContratosAtivos`
- `TelaLogin`

**Responsabilidades:**
- Exibir dados
- Capturar entrada do usuário
- NÃO contém lógica de negócio

---

#### CONTROLLER (Camada de Controle)

**Controllers:**
- `ClienteController`
  - cadastrarCliente(dados)
  - buscarCliente(id)
  
- `ImovelController`
  - cadastrarImovel(dados)
  - listarDisponiveis()
  
- `ContratoController`
  - registrarContrato(clienteId, imovelId, ...)
  - atualizarSituacao(contratoId, novaSituacao)
  - listarAtivos()

**Responsabilidades:**
- Receber requisições da View
- Chamar Model para processar
- Retornar resultado para View

---

### 4.3 Diagrama de Classes MVC Simplificado

```
┌─────────────────────────────────────────┐
│              CONTROLLER                 │
├─────────────────────────────────────────┤
│  ClienteController                      │
│  ImovelController                       │
│  ContratoController                     │
│  ProprietarioController                 │
└──────────────┬──────────────────────────┘
               │
               │ usa
               ▼
┌─────────────────────────────────────────┐
│               MODEL                     │
├─────────────────────────────────────────┤
│  Classes de Domínio:                    │
│  - Cliente                              │
│  - Imovel                               │
│  - Proprietario                         │
│  - Contrato                             │
│                                         │
│  Repositórios:                          │
│  - ClienteRepository                    │
│  - ImovelRepository                     │
│  - ContratoRepository                   │
│                                         │
│  Serviços:                              │
│  - LocacaoService                       │
└──────────────┬──────────────────────────┘
               │
               │ notifica
               ▼
┌─────────────────────────────────────────┐
│               VIEW                      │
├─────────────────────────────────────────┤
│  FormCadastroCliente                    │
│  FormCadastroImovel                     │
│  FormRegistroContrato                   │
│  ListaContratosAtivos                   │
└─────────────────────────────────────────┘
```

---

## DICAS FINAIS

1. **Linguagem Ubíqua:** Use sempre os mesmos termos (ex: "Cliente" e não "Usuário" ou "Locatário")

2. **Contextos Delimitados:** No futuro, se o sistema crescer, pode dividir em contextos (ex: Contexto de Locação, Contexto Financeiro)

3. **Não misture responsabilidades:** View não acessa Model diretamente, sempre via Controller

4. **Validações:** Podem estar no Model (regras de negócio) ou Controller (regras de aplicação)

5. **Diagrama UML:** Use ferramenta como Draw.io, Lucidchart ou até papel para criar o diagrama de classes

---

## Referências Aplicadas

- **Modelo de Domínio:** Linguagem ubíqua, foco no negócio
- **Engenharia de Requisitos:** Funcionais vs Não-Funcionais
- **Casos de Uso:** Fluxo normal + extensões
- **Análise Textual:** Substantivos → Classes, Verbos → Métodos
- **MVC:** Separação clara de responsabilidades