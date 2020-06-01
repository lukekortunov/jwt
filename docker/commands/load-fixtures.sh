#!/usr/bin/env sh

docker exec php-fpm-symfony-jwt-dev bin/console doctrine:fixtures:load -n -q
