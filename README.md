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
### Player (/admin/player)

- [ ] List player (/)
- [ ] Edit player (/{id}/edit)
- [ ] Create player (/new)

### Game (/admin/game)

Properties: Host, Date, Buyin, Noofplayers
- [ ] List game
    - [ ] Edit results link
- [ ] Edit game
    - [ ] Edit results link
- [ ] Create game

### Result (/admin/game/{game_id}/result/)

- ~~List result~~
- [ ] Create game (/new)
- [ ] Edit result (/{id}/edit)
