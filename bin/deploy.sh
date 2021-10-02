#! /bin/bash
set -e
CONTEXT=tgcpl
DOCKER_CMD="docker -c $CONTEXT"

echo "Seeing what is running"
$DOCKER_CMD ps

echo "Backing up DB"
$DOCKER_CMD inspect the-gambling-club-poker-league_php_1 && $DOCKER_CMD cp the-gambling-club-poker-league_php_1:/var/www/html/var/data/poker.sqlite db-backups/poker.$(date +%Y-%m-%d_%H%M).sqlite

echo "Building the assets locally"
docker compose run --rm encore sh -c "yarn install && yarn encore production"

echo "Building and deploying image"
$DOCKER_CMD compose -f docker-compose-prod.yml up -d --build

echo "Waiting 30s for composer install"
sleep 30

echo "Flushing the cloudflare cache"
$DOCKER_CMD compose exec php bin/console app:flush-cloudflare

echo "Removing old images"
$DOCKER_CMD system prune -f

echo "Deployed"
