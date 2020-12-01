FROM php:7.2-cli

RUN apt-get update

RUN apt-get install -y tesseract-ocr tesseract-ocr-all libmagickwand-dev  git unzip

RUN pecl install imagick

COPY ./src /usr/local/nutrisuenos
COPY ./config/Imagemagick/policy.xml /etc/ImageMagick-6/policy.xml

RUN curl -sS https://getcomposer.org/installer \
  | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN docker-php-ext-enable mysqli pdo pdo_mysql imagick

ENV PATH="/usr/local/nutrisuenos:${PATH}"

RUN cd /usr/local/nutrisuenos && composer install --no-dev 