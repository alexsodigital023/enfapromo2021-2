FROM php:7.4-apache

RUN apt-get update && apt-get install -y git zip libicu-dev
COPY ./src/api/config/vhost.conf /etc/apache2/sites-enabled/000-default.conf
COPY ./src/api/config/ports.conf /etc/apache2/ports.conf
COPY ./src/api/src /var/www
COPY ./src/api/config/global.php /var/www/config/autoload/global.php
COPY ./src/api/config/users.htpasswd /var/www/data/users.htpasswd
COPY ./src/api/config/IndexController.php /var/www/module/Application/src/Controller/IndexController.php

RUN docker-php-ext-install mysqli pdo pdo_mysql intl
RUN docker-php-ext-enable mysqli pdo pdo_mysql

RUN curl -sS https://getcomposer.org/installer \
  | php -- --install-dir=/usr/local/bin --filename=composer

RUN a2enmod rewrite

RUN mkdir -p  /var/www/data/cache && chmod 777 /var/www/data -R

COPY ./src/api/config/constants.php /var/www/src/ApiTools/constants.php
RUN cd /var/www && composer update
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
EXPOSE 8080