# Koristimo PHP 8.3 CLI image
FROM php:8.3-cli

# Set radnog direktorija
WORKDIR /var/www/html

# Instaliraj system dependencies potrebne za Symfony i PHP ekstenzije
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libicu-dev \
    libonig-dev \
    libzip-dev \
    zlib1g-dev \
    && docker-php-ext-install pdo pdo_mysql intl mbstring zip opcache

# Instaliraj Composer globalno
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Kopiraj projekt u container
COPY . .

# Instaliraj PHP dependencies
RUN composer install --no-interaction --optimize-autoloader

# Kopiraj entrypoint skriptu
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

RUN php create_db.php
RUN php bin/console doctrine:migrations:migrate --no-interaction

# Expose port za PHP server
EXPOSE 8000

# Start PHP built-in server
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
