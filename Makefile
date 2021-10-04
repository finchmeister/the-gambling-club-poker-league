
.PHONY: up schema-update cc tests exec deploy upload-db remote-logs

up:
	docker-compose up -d
	@echo http://localhost:8081/app_dev.php/

schema-update:
	docker-compose exec php bin/console doctrine:schema:update --force

cc:
	docker-compose exec php bin/console c:c

tests:
	docker compose exec php ./vendor/phpunit/phpunit/phpunit

exec:
	docker-compose exec php bash

deploy:
	./bin/deploy.sh

upload-db:
	docker cp -a db-backups/poker.sqlite the-gambling-club-poker-league_php_1:/var/www/html/var/data/poker.sqlite

remote-logs:
	docker -c tgcpl compose logs -f
