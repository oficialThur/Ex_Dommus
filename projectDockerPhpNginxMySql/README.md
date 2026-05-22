# PASSO 4 — Docker Compose + Stack PHP/Nginx/MySQL

---

## para subir o ambiente Docker  

* Faça todas a config o anbiente e depois um : <strong> sudo docker compose up  --build -d </strong> 

### Como Acessar o MySQL

O serviço do MySQL está configurado para ser acessível tanto de dentro da rede Docker (pelos outros contêineres) quanto externamente a partir do seu computador (host).

#### Acesso via Cliente Externo (DataGrip, DBeaver, MySQL Workbench)

Graças ao mapeamento de portas `3307:3306` no `docker-compose.yml`, você pode se conectar ao banco de dados usando as seguintes credenciais:

- **Host**: `127.0.0.1` ou `localhost`
- **Porta**: `3307`
- **Usuário**: `root`
- **Senha**: `root`
- **Database**: `DbNginx`

#### Acesso via Linha de Comando (dentro de outro contêiner)

Para testar a comunicação interna, você pode acessar o terminal do contêiner PHP e se conectar ao MySQL.

1.  Acesse o terminal do contêiner PHP: `docker compose exec php bash`
2.  Execute o cliente MySQL: `mysql -h mysql -u root -p`
    - `-h mysql`: Usa o nome do serviço (`mysql`) como hostname, que é resolvido pela rede interna do Docker.

### Como Funciona o Proxy Reverso (Nginx)

O Nginx atua como um "porteiro" para a aplicação. Todo o tráfego externo passa primeiro por ele, que então decide para onde encaminhar a requisição.

1.  O usuário acessa `http://meuprojeto.local:8080` no navegador.
2.  O Docker encaminha a requisição da porta `8080` do seu computador para a porta `80` do contêiner `nginx`.
3.  O Nginx recebe a requisição. A diretiva `location ~ \.php$` captura qualquer URI que termine com `.php`.
4.  A instrução `fastcgi_pass php:9000;` encaminha a requisição para o contêiner `php` (usando o nome do serviço como hostname) na porta `9000`, onde o processo PHP-FPM está escutando.
5.  O PHP executa o script e retorna o resultado para o Nginx, que por sua vez o entrega ao navegador do usuário.

### Descrição da Rede Interna (`app-network`)

Foi criada uma rede customizada do tipo `bridge` chamada `app-network`. Todos os três serviços (`mysql`, `php`, `nginx`) foram conectados a ela.

**Vantagens:**

- **Isolamento**: Os contêineres nesta rede podem se comunicar entre si, mas estão isolados de outros contêineres que não pertençam a esta rede.
- **Resolução de Nomes**: O Docker fornece um DNS interno para esta rede. Isso permite que um contêiner encontre o outro usando o nome do serviço definido no `docker-compose.yml` (ex: o Nginx encontra o PHP usando o hostname `php`). Isso é mais robusto do que usar IPs, que podem mudar.
- **Segurança**: Serviços que não precisam ser expostos ao mundo exterior (como o `php`) não têm suas portas mapeadas para o host, garantindo que a comunicação com eles só possa ocorrer de dentro da rede Docker.