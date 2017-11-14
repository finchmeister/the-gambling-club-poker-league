# the-gambling-club-poker-league

## Setup
> TODO: automate with a make file

```
git clone https://github.com/finchmeister/the-gambling-club-poker-league.git
composer install
# Delete the db 
bin/console doctrine:schema:drop --force
bin/console doctrine:schema:update --force
bin/console doctrine:fixtures:load
# Set up league points
bin/console app:update-league-points
bin/console server:run 
```

## TODO
- [x] Show league table
- [ ] List upcoming game
- [ ] List all played games
    - [ ] List results

### Forms
- [ ] Make form theme
- [ ] Ensure all forms use theme
- [ ] Tidy buttons
    - [ ] Large sidebar buttons

### Admin Listings
- [ ] Consider show button


## Edit Game
- [ ] JS form collection tidy
- [ ] Form errors in alerts
- [ ] General tidy
- [ ] Do not allow a player with a game to be deleted

## Edit Player
- [ ] Add image

## Player
- [ ] Hook in real stats

## Dev
- [x] Codesniffer
- [x] Fixtures
- [ ] Phpunit
- [ ] Docker
- [ ] Travis?

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
