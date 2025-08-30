#!/bin/bash
set -e

# Čekaj dok MySQL server ne bude dostupan
until php -r "new PDO('mysql:host=$DB_HOST;port=$DB_PORT', '$DB_USER', '$DB_PASS');" >/dev/null 2>&1; do
  echo "Waiting For MySQL server on $DB_HOST:$DB_PORT..."
  sleep 2
done

# Pokreni migracije bez interaktivnog potvrđivanja
php bin/console doctrine:migrations:migrate --no-interaction

# Startaj Symfony server
php -S 0.0.0.0:8000 -t public
