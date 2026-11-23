#!/bin/sh
set -eu
cd /var/www/html
exec docker-php-entrypoint "$@"
