#!/usr/bin/env bash
set -e

sed -i "s/Listen 80/Listen ${PORT:-10000}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:10000>/<VirtualHost *:${PORT:-10000}>/" /etc/apache2/sites-available/000-default.conf

php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan migrate --force
php artisan db:seed --force
php artisan config:cache
php artisan route:cache
php artisan view:cache

exec apache2-foreground
