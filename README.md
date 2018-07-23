# the-gambling-club-poker-league

[![Build Status](https://travis-ci.org/finchmeister/the-gambling-club-poker-league.svg?branch=master)](https://travis-ci.org/finchmeister/the-gambling-club-poker-league)

## Setup

```
git clone https://github.com/finchmeister/the-gambling-club-poker-league.git
docker-compose up -d
docker-compose exec php bin/console list
docker-compose exec php bin/console app:database-restore
# Deprecated
# docker-compose exec php bin/console doctrine:fixtures:load
```

View at: <http://localhost:8081/app_dev.php/>

## Commands

```
bin/console doctrine:schema:update --force
bin/console doctrine:fixtures:load -n
bin/console app:update-league-points

# Make server available on local network
bin/console server:start 0.0.0.0:8000

# phpunit
./vendor/phpunit/phpunit/phpunit

# Refresh database
bin/console doctrine:schema:drop --force; bin/console doctrine:schema:update --force; bin/console doctrine:fixtures:load -n; bin/console app:update-league-points
```

## Docker Machine

```
export GOOGLE_APPLICATION_CREDENTIALS=google-cloud-auth.json 
docker-machine env vm01
eval $(docker-machine env vm01)

# Disconnect
docker-machine env -u
eval $(docker-machine env -u)

docker-machine create --driver google   --google-project the-gambling-club-poker-league   --google-zone europe-west1-b   --google-machine-type f1-micro   vm01
```

## Docker
```
docker-compose -f docker-compose-prod.yml up -d
docker exec -it CONTAINER_ID /bin/sh
```

## Docker Machine Import

# Travis Secrets:
<https://docs.travis-ci.com/user/encrypting-files/#Encrypting-multiple-files>
```
tar cvf secrets.tar foo bar
travis encrypt-file secrets.tar
```
