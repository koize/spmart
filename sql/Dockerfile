FROM mysql:latest
USER root
COPY ./spmart.sql /docker-entrypoint-initdb.d/spmart.sql
RUN chmod 755 /var/lib/mysql
