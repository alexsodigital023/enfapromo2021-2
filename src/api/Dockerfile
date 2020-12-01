FROM php:7.3-apache

RUN apt-get update
RUN apt-get install -y git unzip

COPY ./config/vhost.conf /etc/apache2/sites-enabled/000-default.conf
COPY ./src /var/www

RUN mkdir mkdir -p /var/www/data/cache \
    &&chown www-data:www-data -R /var/www/data

RUN curl -sS https://getcomposer.org/installer \
  | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN docker-php-ext-enable mysqli pdo pdo_mysql

RUN a2enmod rewrite

RUN cd /var/www && composer install