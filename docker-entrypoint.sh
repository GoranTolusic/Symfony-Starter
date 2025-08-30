#!/bin/bash
set -e

echo "Čekam DNS za MySQL ($DB_HOST)..."

# čekaj dok hostname 'db' može da se resolve-a
until getent hosts "$DB_HOST" >/dev/null 2>&1; do
  sleep 1
done

echo "Čekam MySQL na $DB_HOST:$DB_PORT..."

# čekaj dok MySQL stvarno ne bude spreman
until php -r "new PDO('mysql:host=${DB_HOST};port=${DB_PORT}','${DB_USER}','${DB_PASS}');" >/dev/null 2>&1; do
  sleep 1
done

echo "MySQL je spreman!"

# Pokreni create_db.php ako treba
if [ -f create_db.php ]; then
    php create_db.php
fi

# Pokreni Doctrine migracije
php bin/console doctrine:migrations:migrate --no-interaction || true

echo "Pokrećem PHP-FPM..."
# exec starta PHP-FPM i zamjenjuje skriptu
exec php-fpm
