#!/bin/bash
set -e

echo "Waiting DNS for MySQL ($DB_HOST)..."

# Wait until host db is resolved
until getent hosts "$DB_HOST" >/dev/null 2>&1; do
  sleep 1
done

echo "Waiting MySQL on $DB_HOST:$DB_PORT..."

# Wait for MySQL to be ready
until php -r "new PDO('mysql:host=${DB_HOST};port=${DB_PORT}','${DB_USER}','${DB_PASS}');" >/dev/null 2>&1; do
  sleep 1
done

echo "MySQL is ready!"

#Instalation process: creating database if not exists and migrating tables
composer create-db
composer migrate || true

#Clear and ready cache
composer cache-clear
composer cache-ready

#Opcache info
php -i | grep opcache.enable
php -i | grep opcache.memory_consumption
php -i | grep opcache.max_accelerated_files

#Executing php-fpm process
echo "Executing PHP-FPM..."
exec php-fpm
