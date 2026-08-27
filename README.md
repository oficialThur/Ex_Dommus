# Ex_Dommus

Repositório contendo todas as atividades realizadas na minha trilha de aprendizado durante o período de estágio como Desenvolvedor Full‑stack na Dommus Tecnologia. Este projeto reúne exercícios, implementações e funcionalidades entregues em produção ao longo do estágio.

## Sobre o estágio (resumo)
- Estagiário de Desenvolvimento Full‑stack | Belo Horizonte, MG  
- Integrei a equipe de tecnologia atuando no ciclo completo de desenvolvimento de sistemas web sob supervisão técnica, contribuindo ativamente para entregas reais de produto em produção.
- Desenvolvi e mantive 18 funcionalidades em produção utilizando PHP, JavaScript, AngularJS, Lumen, React e Docker, garantindo aplicações robustas e responsivas para clientes do segmento imobiliário.
- Modelei e otimizei consultas em MySQL, reduzindo em até 10% o tempo de resposta de queries críticas do sistema.
- Controlei versões de código com Git e Bitbucket em equipe distribuída, participando de 18 pull requests com revisão de pares ao longo do estágio.
- Executei testes manuais de homologação cobrindo funcionalidades‑chave antes de cada deploy, contribuindo para a redução de bugs reportados em produção.
- Participei de Dailies e Sprints semanais sob o framework Kanban, ajudando a manter cadência de entregas contínuas em 2 ciclos completos.
- Identifiquei e corrigi 10 falhas técnicas reportadas pela equipe de QA, reduzindo o backlog de bugs do time e elevando a qualidade do produto final.

## Tecnologias utilizadas
- Linguagens: PHP, JavaScript, HTML, CSS
- Frameworks / Bibliotecas: Lumen, AngularJS, React
- Banco de dados: MySQL
- Contêineres / DevOps: Docker
- Controle de versão: Git (Fluxo de PR / revisão de pares)

## O que há neste repositório
Este repositório reúne:
- Exercícios e atividades da trilha de aprendizado
- Implementações de funcionalidades (back-end e front-end)
- Scripts e exemplos de queries MySQL otimizadas
- Dockerfile(s) e/ou exemplos de configuração para ambientes locais
- Notas de homologação / testes manuais realizados

(Explore as pastas para ver cada atividade; os nomes de diretórios refletem as tarefas e tecnologias empregadas.)

## Como rodar (guia rápido)
Observação: os comandos abaixo são um guia genérico — adapte à estrutura real do repositório (pasta `backend`, `frontend`, `docker`, etc.).

Pré‑requisitos:
- PHP (versão compatível com o projeto)
- Composer
- Node.js e npm ou yarn
- MySQL (ou contêiner com MySQL)
- Docker / docker-compose (opcional, recomendado para ambiente consistente)

Passos gerais:
1. Clone o repositório:
   git clone https://github.com/oficialThur/Ex_Dommus.git
2. Configure variáveis de ambiente:
   - Copie arquivos de exemplo `.env.example` → `.env` e ajuste credenciais de BD, chaves, etc.
3. Back-end (PHP / Lumen):
   - Vá para a pasta do back-end (ex.: `cd backend`)
   - composer install
   - Configure o banco de dados e execute migrations/seeders (se existirem)
   - Inicie o servidor (ex.: `php -S localhost:8000 -t public` ou `php artisan serve`)
4. Front-end (React / AngularJS):
   - Vá para a pasta do front-end (ex.: `cd frontend`)
   - npm install ou yarn
   - npm start / yarn start para desenvolvimento
5. Usando Docker (se houver docker-compose.yml):
   - docker-compose up --build
   - Acesse os serviços conforme as portas definidas

## Testes e homologação
- Testes realizados durante o estágio foram majoritariamente manuais de homologação, cobrindo fluxos críticos antes de cada deploy.
- Inclua instruções de testes automatizados aqui se o projeto tiver testes unitários/integrados (ex.: `npm test`, `phpunit`).

## Boas práticas adotadas
- Controle de versão com PRs e revisão de pares.
- Migração e seed de banco para reprodutibilidade.
- Uso de containers (Docker) para padronizar ambiente de desenvolvimento.
- Otimização de queries MySQL e monitoramento de performance.

## Sugestões para melhoria do README
- Adicionar exemplos concretos de execução (comandos reais para pastas específicas).
- Incluir screenshots ou GIFs das interfaces quando houver front‑end.
- Documentar a estrutura de cada pasta e endpoints da API (Swagger/OpenAPI se disponível).
- Anexar arquivo LICENSE (recomendo MIT se você quiser liberdade de uso).

## Contribuição
Contribuições são bem‑vindas — abra issues para relatar bugs ou propostas de melhoria e envie pull requests para revisão.

## Contato
- GitHub: https://github.com/oficialThur
- Projeto: https://github.com/oficialThur/Ex_Dommus

---
Este README foi preparado com base na descrição do seu currículo e na finalidade do repositório (atividades da trilha do estágio). Se quiser, eu posso:
- Ajustar o conteúdo para incluir instruções específicas de pastas/arquivos presentes no repositório (se você indicar a estrutura ou permitir que eu leia os arquivos);
- Criar/commitar o README.md diretamente no repositório (após sua confirmação).
