FROM mysql:latest

WORKDIR /app

ADD . /app

USER mysql

ENV MYSQL_USER=arthur
ENV MYSQL_DATABASE=Arthur_database

EXPOSE 3306

CMD ["mysql"]