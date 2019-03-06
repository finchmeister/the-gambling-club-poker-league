#! /bin/bash

eval $(docker-machine env vm02)
docker-compose -f docker-compose-prod.yml up -d --build
docker-compose exec php bin/console doctrine:schema:update --force
