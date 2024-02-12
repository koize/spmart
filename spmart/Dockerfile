FROM php:8.1-apache

RUN apt-get update && \
    docker-php-ext-install mysqli pdo pdo_mysql && apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev \
    # configure the GD extension to include support for JPEG and PNG image formats
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

RUN chmod -R 777 /var/www/html
