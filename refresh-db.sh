#!/usr/bin/env sh

bin/console doctrine:schema:drop -n -q --force --full-database &&
rm -f src/Migrations/*.php &&
bin/console make:migration &&
bin/console doctrine:migrations:migrate -n -q &&
bin/console doctrine:fixtures:load -n -q
