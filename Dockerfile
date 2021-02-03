FROM php:7.4-apache

RUN apt-get update && apt-get install -y git zip 
COPY ./src/backend/config/vhost.conf /etc/apache2/sites-enabled/000-default.conf
COPY ./src/backend/src /var/www
COPY ./src/backend/config/env-production /var/www/.env

RUN docker-php-ext-install mysqli pdo pdo_mysql gd
RUN docker-php-ext-enable mysqli pdo pdo_mysql


RUN curl -sS https://getcomposer.org/installer \
  | php -- --install-dir=/usr/local/bin --filename=composer

RUN a2enmod rewrite

RUN mkdir -p /var/www/data \
   && mkdir -p /var/www/data/cache

RUN chown www-data:www-data -R /var/www/bootstrap/cache\
    &&chown www-data:www-data -R /var/www/storage\
    &&chown www-data:www-data -R /var/www/public\
    &&chown www-data:www-data -R /var/www/data

RUN cd /var/www && composer install --no-dev 
RUN cd /var/www && php artisan migrate:fresh --seed