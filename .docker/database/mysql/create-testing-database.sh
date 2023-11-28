#!/usr/bin/env bash

mysql --user=root --password="$MYSQL_ROOT_PASSWORD" <<-EOSQL
    CREATE USER 'www'@'%' IDENTIFIED BY '$MYSQL_PASSWORD';
    CREATE DATABASE IF NOT EXISTS laravel;
    CREATE DATABASE IF NOT EXISTS testing;
    GRANT ALL PRIVILEGES ON \`$DB_DATABASE%\`.* TO 'root'@'%';
    GRANT ALL PRIVILEGES ON \`$DB_DATABASE%\`.* TO 'www'@'%';
    GRANT ALL PRIVILEGES ON \`testing%\`.* TO 'root'@'%';
    GRANT ALL PRIVILEGES ON \`testing%\`.* TO 'www'@'%';
    FLUSH PRIVILEGES;
EOSQL
