#!/usr/bin/env sh
set -eu

APP_ROOT=/tmp/simbima/app
rm -rf "$APP_ROOT"
mkdir -p "$APP_ROOT"
tar --exclude='./vendor' -C /var/www/html -cf - . | tar -C "$APP_ROOT" -xf -
mkdir -p "$APP_ROOT/vendor"
tar -C "$APP_ROOT/vendor" -xzf /opt/vendor.tar.gz
cd "$APP_ROOT"

mkdir -p "${VIEW_COMPILED_PATH:-/tmp/simbima/views}"
export APP_CONFIG_CACHE=/tmp/simbima/config.php
rm -f "$APP_CONFIG_CACHE" bootstrap/cache/config.php

export DB_CONNECTION=pgsql
export DB_PORT=5432
export SESSION_CONNECTION=pgsql
export DB_CACHE_CONNECTION=pgsql
export DB_CACHE_LOCK_CONNECTION=pgsql

if [ -n "${MYSQL_CA_CERT_BASE64:-}" ]; then
    printf '%s' "$MYSQL_CA_CERT_BASE64" | base64 -d > /tmp/aiven-ca.pem
    export MYSQL_ATTR_SSL_CA=/tmp/aiven-ca.pem
fi

exec php artisan serve --host=0.0.0.0 --port="${PORT:-3000}"
