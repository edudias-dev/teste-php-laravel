FROM php:8.1-fpm

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        libpq-dev \
        libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

WORKDIR /var/www/html

COPY . /var/www/html

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install --no-interaction --optimize-autoloader

CMD ["php-fpm"]

EXPOSE 9000
