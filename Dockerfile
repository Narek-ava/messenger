FROM php:8.3-fpm

RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libpq-dev \
    libzip-dev \
    zip unzip curl git \
    && docker-php-ext-install exif

# PHP Extensions
RUN docker-php-ext-install pdo pdo_mysql zip gd

# Установка и включение pcntl
RUN apt-get update && apt-get install -y libzip-dev \
    && docker-php-ext-install pcntl

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
