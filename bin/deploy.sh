#! /bin/bash
set -e

eval $(docker-machine env vm02)
echo "Backing up DB"
docker inspect the-gambling-club-poker-league_php_1 && docker cp the-gambling-club-poker-league_php_1:/var/www/html/var/data/poker.sqlite db-backups/poker.$(date +%Y-%m-%d_%H%M).sqlite

echo "Building and deploying image"
docker-compose -f docker-compose-prod.yml up -d --build

echo "Updating schema"
docker-compose exec php bin/console doctrine:schema:update --force

echo "Flushing the cloudflare cache"
docker-compose exec php bin/console app:flush-cloudflare

echo "Removing old images"
docker system prune -f

echo "Deployed"