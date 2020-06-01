#!/usr/bin/env sh

sh ../doctrine-drop-schema-force.sh &&
sh ../delete-migrations.sh &&
sh ../make-migrations.sh &&
sh ../migrate.sh &&
sh ../load-fixtures.sh
