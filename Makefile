# TODO

.PHONY: schema-update cc

schema-update:
	docker-compose exec php bin/console doctrine:schema:update --force

cc:
	docker-compose exec php bin/console c:c