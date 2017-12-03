#! /bin/bash

export GOOGLE_APPLICATION_CREDENTIALS=google-cloud-auth.json

docker-machine ls
docker-machine env vm01
eval $(docker-machine env vm01)
docker-machine ls

docker-compose -f docker-compose-prod.yml up -d
docker-compose exec php composer install --prefer-dist --no-progress --no-suggest
docker-compose exec php chown -R www-data:www-data var/
docker-compose exec php bin/console doctrine:schema:update --force
