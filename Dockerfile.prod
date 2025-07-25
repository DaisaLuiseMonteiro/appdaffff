# Dockerfile

FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    nginx \
    supervisor \
    libpq-dev \
    libzip-dev \
    zip unzip \
    git curl \
    && docker-php-ext-install pdo pdo_pgsql pgsql

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-interaction --prefer-dist --optimize-autoloader

COPY nginx.conf /etc/nginx/sites-available/default
COPY supervisord.conf /etc/supervisord.conf

EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]