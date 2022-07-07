FROM php:8.1.5-fpm

RUN apt-get update

RUN apt-get install libzip-dev zip libicu-dev libpq-dev -y

RUN docker-php-ext-install zip && docker-php-ext-configure intl && docker-php-ext-install intl

RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable pdo_mysql
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql && docker-php-ext-install pdo_pgsql pgsql

WORKDIR /var/www/app

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
