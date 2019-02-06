# the-gambling-club-poker-league

[![Build Status](https://travis-ci.org/finchmeister/the-gambling-club-poker-league.svg?branch=master)](https://travis-ci.org/finchmeister/the-gambling-club-poker-league)


## Docker Machine

```
export GOOGLE_APPLICATION_CREDENTIALS=google-cloud-auth.json 
docker-machine env vm02
eval $(docker-machine env vm02)

# Disconnect
docker-machine env -u
eval $(docker-machine env -u)
```

## Docker
```
docker-compose -f docker-compose-prod.yml up -d
docker exec -it CONTAINER_ID /bin/sh
```

Get DB from prod:

```
eval $(docker-machine env vm02)
docker cp thegamblingclubpokerleague_php_1:/var/www/html/var/data/poker.sqlite var/data/poker.sqlite
```

## Docker Machine Import

# Travis Secrets:
<https://docs.travis-ci.com/user/encrypting-files/#Encrypting-multiple-files>
```
tar cvf secrets.tar foo bar
travis encrypt-file secrets.tar
```

## Changing instance
1\. Create instance: 
```
docker-machine create --driver google   --google-project the-gambling-club-poker-league   --google-zone us-east1-b   --google-machine-type f1-micro   vm02
```
2\. Export machine
```
machine-export vm02
```
3\. Update secrets and encrypt:
```
tar cvf secrets.tar  google-cloud-auth.json vm02.zip
travis encrypt-file secrets.tar
```
4\. Update vm name in .travis.yml

5\. Update gitignore and dockerignore

6\. Start application via docker-compose
```
docker-machine env vm02
eval $(docker-machine env -u)
docker-compose -f docker-compose-prod.yml up -d
```
7\. Restore db in app (note permissions of the db)
```
docker-compose exec php bin/console app:database-restore
```
8\. Update DNS to point to new server