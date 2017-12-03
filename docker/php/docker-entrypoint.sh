#!/bin/sh
set -e

ls


## first arg is `-f` or `--some-option`
#if [ "${1#-}" != "$1" ]; then
#	set -- php-fpm "$@"
#fi
#
#if [ "$1" = 'php-fpm' ] || [ "$1" = 'bin/console' ]; then
#	ls
#	#composer install --prefer-dist --no-progress --no-suggest --no-interaction
#	#bin/console doctrine:schema:update --force
#
#	#chown -R www-data var
#fi
#
#exec docker-php-entrypoint "$@"
