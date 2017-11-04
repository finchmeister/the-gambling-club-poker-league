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

## Home (/)
- [x] Show league table
- [x] List upcoming game
- [ ] List all played games
    - [ ] List results

## Admin (/admin)
CRUD stuff
- [ ] Player (/admin/player)
- [ ] Game & results (/admin/game)

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

# Refresh database
bin/console doctrine:schema:drop --force; bin/console doctrine:schema:update --force; bin/console doctrine:fixtures:load -n; bin/console app:update-league-points
```
