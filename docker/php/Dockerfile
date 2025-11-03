FROM php:8.2-fpm

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libicu-dev \
    && docker-php-ext-install pdo pdo_mysql intl 

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

