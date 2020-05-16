
.PHONY: up schema-update cc tests exec deploy local-db-backup local-db-restore

up:
	docker-compose up -d
	@echo http://localhost:8081/app_dev.php/

schema-update:
	docker-compose exec php bin/console doctrine:schema:update --force

cc:
	docker-compose exec php bin/console c:c

tests:
	docker-compose exec php ./vendor/phpunit/phpunit/phpunit

exec:
	docker-compose exec php /bin/sh

deploy:
	./bin/deploy.sh

local-db-backup:
	cp var/data/poker.sqlite var/data/poker.sqlite.bak

local-db-restore:
	cp var/data/poker.sqlite.bak var/data/poker.sqlite
