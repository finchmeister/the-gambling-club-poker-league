#!/bin/bash
echo "hello world"

docker-compose build

docker-compose up -d

docker-compose exec php ./vendor/phpunit/phpunit/phpunit

