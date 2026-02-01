FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libicu-dev \
    supervisor \
    && apt-get clean && rm -rf /var/lib/apt/lists/*


RUN docker-php-ext-install \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    intl \
    zip

RUN docker-php-ext-configure intl && docker-php-ext-install intl

RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo_pgsql

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY --chown=www-data:www-data composer.json composer.lock ./

RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-scripts

COPY --chown=www-data:www-data . .

RUN mkdir -p storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

USER www-data

#EXPOSE 10000
#
#CMD php artisan serve --host 0.0.0.0 --port $PORT
