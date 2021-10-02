# the-gambling-club-poker-league

[![Build Status](https://travis-ci.org/finchmeister/the-gambling-club-poker-league.svg?branch=master)](https://travis-ci.org/finchmeister/the-gambling-club-poker-league)

Home to The Gambling Club's poker results - https://thegamblingclub.co.uk/

## Setup

1. Grab the secret files and cloudflare config from the secret location. Add `google-cloud-auth.json` file and update the cloudflare params.

2. Start the project with `make up`
3. Copy a sqlite DB into the project with `make upload-db`
4. Go to: http://localhost:8081/app_dev.php

## Deploy

```
make deploy
```

## Changing instance
1. Export a copy of the database.
2. Create instance wherever, provide ssh access and install the docker engine on it.
3. Create the docker context `tgcpl` on the machine to be deployed from, e.g:
   ```
   docker context create tgcpl --docker "host=ssh://jonathan.finch@104.198.144.70"
   ```
4. Run `make deploy`
5. Upload a db to the server:
   ```docker -c tgcpl cp -a db-backups/poker.sqlite the-gambling-club-poker-league_php_1:/var/www/html/var/data/poker.sqlite```
5. Update DNS to point to new server