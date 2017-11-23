#!/bin/bash
echo "hello world"

docker-compose build

docker-compose up -d

until [ "`/usr/bin/docker inspect -f {{.State.Running}} php`" == "true" ]; do
    sleep 0.1;
done;

docker-compose exec php ./vendor/phpunit/phpunit/phpunit
