#!/bin/bash
echo "hello world"

docker-compose build

docker-compose up -d

sleep 10;

docker-compose exec php ./vendor/phpunit/phpunit/phpunit
