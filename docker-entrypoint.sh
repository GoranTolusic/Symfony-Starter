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

#Instalation process: creating database and migrating tables
if [ -f create_db.php ]; then
    composer create-db
fi
composer migrate || true

#Clear cache
composer cache-clear

#Executing php-fpm process
echo "Executing PHP-FPM..."
exec php-fpm
