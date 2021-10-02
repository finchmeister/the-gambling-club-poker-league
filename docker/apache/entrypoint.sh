#!/usr/bin/env bash

composer install -n
bin/console doctrine:schema:update --force

exec "$@"
