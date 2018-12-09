
.PHONY: up schema-update cc tests exec

up:
	docker-compose up -d

schema-update:
	docker-compose exec php bin/console doctrine:schema:update --force

cc:
	docker-compose exec php bin/console c:c

tests:
	docker-compose exec php ./vendor/phpunit/phpunit/phpunit

exec:
	docker-compose exec php /bin/sh