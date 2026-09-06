#!/usr/bin/env sh
set -eu

mkdir -p "${VIEW_COMPILED_PATH:-/tmp/simbima/views}"
export APP_CONFIG_CACHE=/tmp/simbima/config.php

export DB_CONNECTION=pgsql
export DB_PORT=5432
export SESSION_CONNECTION=pgsql
export DB_CACHE_CONNECTION=pgsql
export DB_CACHE_LOCK_CONNECTION=pgsql

exec php artisan serve --host=0.0.0.0 --port="${PORT:-3000}"
