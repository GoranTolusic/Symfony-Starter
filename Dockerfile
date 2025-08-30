# Koristimo PHP 8.3 FPM image
FROM php:8.3-fpm

WORKDIR /var/www/html

# Instaliraj system dependencies i PHP ekstenzije
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libicu-dev \
    libonig-dev \
    libzip-dev \
    zlib1g-dev \
    && docker-php-ext-install pdo pdo_mysql intl mbstring zip opcache \
    && apt-get clean

# Instaliraj Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Kopiraj projekt
COPY . .

# Instaliraj PHP dependencies
RUN composer install --no-interaction --optimize-autoloader

# Kopiraj entrypoint
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Postavi entrypoint
ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]

# PHP-FPM koristi defaultni port 9000
EXPOSE 9000
