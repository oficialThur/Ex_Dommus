## comandos usados: 
    * sudo docker run -d --name mysql_local -p 3306:3306 mysql
    * sudo docker ps -a
    * sudo docker exec
    * sudo docker rm mysql_local
    * sudo docker logs

## Nome do volume/ image:
    * /var/lib/mysql
    * mysql
## evidencia: 
    artur@dev010:~/Dommus/trilha-treinamento/projectDocker$ sudo docker exec -it mysql-oficial mysql -u root -p
    Enter password: 
    Welcome to the MySQL monitor.  Commands end with ; or \g.
    Your MySQL connection id is 12
    Server version: 8.0.44 MySQL Community Server - GPL

    Copyright (c) 2000, 2025, Oracle and/or its affiliates.

    Oracle is a registered trademark of Oracle Corporation and/or its
    affiliates. Other names may be trademarks of their respective
    owners.

    Type 'help;' or '\h' for help. Type '\c' to clear the current input statement.

    mysql> use arthur;
    Reading table information for completion of table and column names
    You can turn off this feature to get a quicker startup with -A

    Database changed
    mysql> exit
    Bye
    artur@dev010:~/Dommus/trilha-treinamento/projectDocker$ 


    

