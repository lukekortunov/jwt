#!/usr/bin/env sh

docker exec php-fpm-symfony-jwt-dev find /app/src/Migrations -maxdepth 1 -name '*.php' -exec rm {} \;
