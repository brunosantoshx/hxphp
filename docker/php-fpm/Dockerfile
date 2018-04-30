FROM php:7-fpm

RUN apt-get update && apt-get install -y libmcrypt mysql-client \
    && docker-php-ext-install mcrypt pdo_mysql

WORKDIR /var/www/html