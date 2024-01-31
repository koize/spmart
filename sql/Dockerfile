FROM yobasystems/alpine-mariadb:latest
USER root
COPY ./spmart.sql /docker-entrypoint-initdb.d/spmart.sql
RUN chmod 777 /docker-entrypoint-initdb.d/spmart.sql
RUN mkdir /var/lib/mysql
RUN chmod 777 /var/lib/mysql