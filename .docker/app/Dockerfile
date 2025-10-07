ARG PHP_VERSION=8.3
FROM php:${PHP_VERSION}-fpm-alpine
RUN apk add --no-cache git curl bash icu-dev oniguruma-dev libzip-dev libpng-dev libjpeg-turbo-dev freetype-dev libxml2-dev linux-headers autoconf make g++ shadow nodejs npm
RUN docker-php-ext-configure gd --with-jpeg --with-freetype \
&& docker-php-ext-install -j$(nproc) gd intl zip pdo pdo_mysql mysqli opcache bcmath pcntl
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN useradd -u 1000 -m laravel && usermod -aG www-data laravel
USER laravel
WORKDIR /var/www/html
COPY .docker/app/php.ini /usr/local/etc/php/conf.d/app.ini
CMD ["php-fpm"]