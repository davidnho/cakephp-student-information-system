#!/bin/sh
set -eu

cd /var/www/html

# Render free services do not provide a shell for one-off migration commands.
# Set RUN_MIGRATIONS=true in Render for the initial deployment. Migrations are
# idempotent; leaving this enabled runs pending migrations on each container start.
if [ "${RUN_MIGRATIONS:-false}" = "true" ]; then
    php bin/cake.php migrations migrate --no-interaction
fi

exec docker-php-entrypoint "$@"
