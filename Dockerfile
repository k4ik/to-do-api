FROM php:8.3-apache

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install zip pdo pdo_mysql \
    && a2enmod rewrite

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY ./ ./ 

RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

RUN composer install --no-dev --optimize-autoloader

EXPOSE 80
