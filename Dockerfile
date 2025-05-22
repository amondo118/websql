FROM php:8.1-apache

WORKDIR /var/www/html

RUN apt-get update && \
    apt-get install -y \
    libzip-dev \
    unzip \
    && docker-php-ext-install mysqli pdo pdo_mysql \
    && a2enmod rewrite

COPY . .

EXPOSE 10000
CMD ["php", "-S", "0.0.0.0:10000", "-t", "."]