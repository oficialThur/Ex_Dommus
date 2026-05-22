
# API de Reajuste em Camadas.

Você já possui, da etapa anterior, um domínio orientado a objetos para reajuste de preços de imóveis, contendo:

    Imovel

    ItemReajustavelInterface

    ReajusteTrait

    AbstractReajusteService

    ReajusteImovelService



Esse código deve ser reaproveitado, com ajustes mínimos quando necessário.
Não é permitido reescrever o domínio do zero.

Você deverá evoluir o sistema existente para permitir persistência em banco de dados, seguindo os padrões adotados nas APIs legadas da empresa.

A solução final deve estar organizada em três camadas bem definidas:

    Camada de I/O

    Camada de Negócios

    Camada de Persistência


## Requisitos de implementação

Camada de Persistência — PDO Singleton

Crie uma classe Connection que:

- Implemente o padrão Singleton

- Encapsule a instância de PDO

- Garanta:

        Apenas uma conexão ativa

        Configuração de:

            PDO::ATTR_ERRMODE
            			=> PDO::ERRMODE_EXCEPTION

            PDO::ATTR_DEFAULT_FETCH_MODE
            			=> PDO::FETCH_ASSOC


Exemplo de responsabilidade (não código):

Fornecer uma instância única de PDO para toda a aplicação.

## Camada de Persistência — DAO

Crie uma interface ImovelDaoInterface definindo:

    findAll():
    	array

    update(Imovel
    	$imovel): void

Crie a classe concreta ImovelDaoPdo que:

    Implemente ImovelDaoInterface

    Utilize PDO via Singleton

    Não contenha lógica de negócio

    Lance exceções em caso de erro de persistência

## Factory de DAO

Crie uma classe DaoFactory responsável por:

    Criar instâncias de DAOs

    Isolar a camada de negócio da implementação concreta

    Expor um método estático:

    public static function createImovelDao(): ImovelDaoInterface

## A camada de negócio não deve instanciar DAOs diretamente.    

Camada de Negócios — Service

Adapte o ReajusteImovelService para:

    Receber o DAO por injeção de dependência

    Buscar os imóveis via DAO

    Aplicar o reajuste utilizando o domínio existente

    Persistir os imóveis reajustados

## O service não deve conhecer SQL nem detalhes de persistência.

Camada de I/O

Crie um script (ex.: reajustar_imoveis.php) responsável apenas por:

    Ler parâmetros de entrada (ex.: percentual)

    Instanciar o service via Factory

    Capturar exceções

    Retornar resposta ao cliente (HTML simples ou JSON)


## Nenhuma regra de negócio deve existir nessa camada.

Tratamento de Exceções

Utilize exceções para:

        Erros de conexão

        Erros de persistência

        Entradas inválidas

Não utilize:

        die

        exit

        echo para controle de fluxo


## Requisitos técnicos obrigatórios

- DAO
- Singleton
- Factory
- Arquitetura em três camadas
- Reuso do domínio da etapa anterior
- Tratamento adequado de exceções
- Separação clara de responsabilidades

## Não é permitido:

- SQL fora do DAO

- new
    PDO fora do Singleton

- new
    ImovelDaoPdo fora da Factory

- Código procedural misturado ao domínio

---

Parte 1: A Conexão com o Banco (Singleton)
O primeiro passo é garantir que sua aplicação consiga falar com o banco de dados. O requisito pede o padrão Singleton.

O que é PDO? PDO (PHP Data Objects) é uma classe nativa do PHP que serve como uma interface para acessar bancos de dados. Pense nele como um "tradutor universal" entre o PHP e o MySQL (ou outros bancos).

Como fazer a classe Connection:

Crie uma classe chamada Connection.
Propriedade Estática: Ela deve ter uma variável privada e estática (ex: private static $instance) para guardar a conexão única.
Construtor Privado: O método __construct() deve ser private. Isso impede que alguém faça new Connection() fora da classe.
Método getInstance(): Crie um método público e estático. A lógica dele é:
Verifica se a variável $instance está vazia.
Se estiver vazia, cria uma nova instância da classe nativa PDO (passando o host, nome do banco, usuário e senha) e salva nessa variável.
Configure os atributos obrigatórios (ATTR_ERRMODE e ATTR_DEFAULT_FETCH_MODE) logo após criar o PDO.
Retorna a $instance.
Parte 2: A Camada de Persistência (DAO)
DAO significa Data Access Object. A ideia é que o seu código de negócio (Service) nunca escreva SQL diretamente. Quem escreve SQL é o DAO.

Passo 2.1: A Interface (ImovelDaoInterface) Crie uma interface simples. Ela serve como um contrato. Ela deve declarar apenas dois métodos:

findAll(): que deve retornar um array.
update(Imovel $imovel): que recebe o objeto do seu domínio e retorna void.
Passo 2.2: A Implementação (ImovelDaoPdo) Crie a classe que implementa a interface acima.

Construtor: Pode receber a conexão PDO, ou você pode chamar o Singleton dentro dos métodos (embora injetar no construtor seja mais limpo, o Singleton permite chamar direto).
Implementar findAll():
Escreva o SQL: SELECT * FROM imoveis.
Use o método query() ou prepare() do PDO.
Hidratação: O banco devolve arrays associativos (linhas da tabela). Você precisa percorrer esses dados (foreach) e, para cada linha, dar um new Imovel(...) preenchendo com os dados do banco. Retorne um array desses objetos.
Implementar update(Imovel $imovel):
Escreva o SQL: UPDATE imoveis SET valor = :valor WHERE id = :id.
Use prepare() do PDO (explico abaixo).
Vincule os valores do objeto $imovel aos placeholders (:valor, :id) usando bindValue.
Execute.
Parte 3: A Factory (Fábrica)
O requisito pede que a camada de negócio não dê new ImovelDaoPdo(). Para isso serve a Factory.

Como fazer:

Crie uma classe DaoFactory.
Crie um método estático createImovelDao().
Dentro dele, apenas retorne uma nova instância de ImovelDaoPdo.
Se o seu DAO precisar da conexão no construtor, é aqui que você chama Connection::getInstance() e passa para ele.
Parte 4: A Camada de Negócio (Service)
Você vai adaptar o seu ReajusteImovelService existente.

Mudanças necessárias:

Injeção de Dependência: O serviço não deve criar o DAO. Ele deve receber um objeto do tipo ImovelDaoInterface no construtor e guardá-lo numa propriedade.
Método de processar:
Em vez de receber um JSON ou array direto, ele chama $this->dao->findAll() para pegar os objetos do banco.
Faz o loop nos imóveis (que já são objetos).
Aplica o reajuste (usando o método do próprio objeto Imovel ou a lógica de domínio que você já tem).
Chama $this->dao->update($imovel) para salvar o novo preço no banco.
Parte 5: A Camada de I/O (Script/Controller)
Este é o ponto de entrada (o arquivo reajustar_imoveis.php ou o Controller).

Fluxo:

Receba o input (ex: $_POST['percentual']).
Use a Factory para criar o DAO: $dao = DaoFactory::createImovelDao();.
Instancie o Service passando o DAO: $service = new ReajusteImovelService($dao);.
Chame o método de processar do service passando o percentual.
Envolva tudo num bloco try...catch para capturar erros e exibir mensagens amigáveis.
Mini-Aula de PDO (Para quem não sabe mexer)
Como você disse que não sabe mexer com PDO, aqui vão os 4 conceitos vitais para não errar:

Prepare (prepare): Nunca coloque variáveis direto na string do SQL (ex: "SELECT * FROM t WHERE id = $id"). Isso gera falha de segurança (SQL Injection). Sempre use: $stmt = $pdo->prepare("SELECT * FROM t WHERE id = :id");. O :id é um apelido seguro.

Bind (bindValue): É aqui que você diz pro PHP o que é aquele apelido. $stmt->bindValue(':id', $idDoImovel); O PDO trata os dados, escapa caracteres perigosos e garante segurança.

Execute (execute): Depois de preparar e vincular, você manda rodar: $stmt->execute();.

Fetch (fetch ou fetchAll): Para ler dados (SELECT), depois de executar, você precisa buscar os resultados. $resultado = $stmt->fetchAll(); traz todas as linhas.
