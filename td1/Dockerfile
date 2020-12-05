FROM php:7.4-apache 
WORKDIR /var/www/html 
RUN apt-get -y update && apt-get -y upgrade && \
    docker-php-ext-install pdo_mysql

