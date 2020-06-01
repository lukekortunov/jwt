#!/usr/bin/env sh

docker exec php-fpm-symfony-jwt-dev bin/console doctrine:schema:drop -n -q --force --full-database
