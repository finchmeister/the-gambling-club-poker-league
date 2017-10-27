# the-gambling-club-poker-league

## Setup
> TODO: automate with a make file

```
git clone https://github.com/finchmeister/the-gambling-club-poker-league.git
composer install
bin/console doctrine:schema:update --force
bin/console doctrine:fixtures:load
bin/console server:run 
```


## Home (/)
- [ ] Show league table
- [ ] List upcoming game
- [ ] List all played games
    - [ ] List results

## Admin (/admin)
CRUD stuff
- [ ] Player (/admin/player)
- [ ] Game (/admin/game)
- [ ] Result (/admin/game/{game_id}/result/)

## Dev
- [x] Codesniffer
- [ ] Fixtures
- [ ] Phpunit
- [ ] Docker
- [ ] Travis?

## Commands

```
bin/console doctrine:schema:update --force
bin/console doctrine:fixtures:load -n
```