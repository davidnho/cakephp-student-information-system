FROM php:8.3-apache

ENV APACHE_DOCUMENT_ROOT=/var/www/html/webroot
ENV PORT=10000
ENV COMPOSER_ALLOW_SUPERUSER=1

RUN apt-get update && apt-get install -y --no-install-recommends \
    git unzip libicu-dev libonig-dev \
    && docker-php-ext-install -j"$(nproc)" intl mbstring \
    && a2enmod rewrite headers \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

RUN composer install --no-dev --prefer-dist --no-interaction --no-progress --optimize-autoloader \
    && mkdir -p tmp/cache/persistent tmp/cache/models tmp/sessions logs storage \
    && chown -R www-data:www-data tmp logs storage \
    && chmod -R 775 tmp logs storage

COPY docker/ports.conf /etc/apache2/ports.conf
COPY docker/000-default.conf /etc/apache2/sites-available/000-default.conf
RUN chown -R www-data:www-data /var/www/html/storage

EXPOSE 10000
CMD ["apache2-foreground"]
