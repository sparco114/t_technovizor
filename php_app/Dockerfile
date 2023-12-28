FROM php:8.3.0-fpm


RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

RUN apt update \
    && apt -y install git unzip \
    && apt -y install libzip-dev libpng-dev libfreetype6-dev libjpeg62-turbo-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install zip pdo pdo_mysql gd

WORKDIR /var/www/html

COPY . .

RUN cd /var/www/html/tvz && composer install

RUN chown -R www-data:www-data /var/www/html/tvz/

USER www-data

EXPOSE 9000

