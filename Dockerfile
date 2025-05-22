FROM php:8.1-apache

WORKDIR /var/www/html

RUN apt-get update && \
    apt-get install -y \
    libzip-dev \
    unzip \
    default-mysql-client && \
    docker-php-ext-install mysqli pdo pdo_mysql && \
    a2enmod rewrite

COPY . .

ENV DB_HOST=host.docker.internal
ENV DB_USER=root
ENV DB_PASS=root
ENV DB_NAME=adatok

EXPOSE 80