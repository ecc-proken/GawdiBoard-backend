FROM mysql:8.0

ENV TZ='Asia/Tokyo'

RUN mkdir /var/log/mysql && chown mysql:mysql /var/log/mysql

COPY ./infra/docker/mysql/my.cnf /etc/my.cnf
