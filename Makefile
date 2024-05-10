current-dir := $(dir $(abspath $(lastword $(MAKEFILE_LIST))))

.PHONY: build
build: start

# 🐳 Docker Compose
.PHONY: start
start: CMD=up --build -d

.PHONY: stop
stop: CMD=stop

.PHONY: destroy
destroy: CMD=down

# Usage: `make doco CMD="ps --services"`
# Usage: `make doco CMD="build --parallel --pull --force-rm --no-cache"`
.PHONY: doco
doco start stop destroy:
	UID=${shell id -u} GID=${shell id -g} docker-compose $(CMD)

.PHONY: deps
deps:
	docker exec microservice_battle_php composer install
	docker exec microservice_location_php composer install
	docker exec microservice_secret_php composer install
	docker exec microservice_user_php composer install
	docker exec microservice_secret_php php artisan migrate
	docker exec microservice_user_php php artisan migrate
	docker exec microservice_secret_php php artisan db:seed
	docker exec microservice_user_php php artisan db:seed

.PHONY: test
test:
	docker exec microservice_battle_php ./vendor/bin/phpunit --testdox
	docker exec microservice_location_php ./vendor/bin/phpunit --testdox
	docker exec microservice_secret_php ./vendor/bin/phpunit --testdox
	docker exec microservice_user_php ./vendor/bin/phpunit --testdox
	docker exec microservice_user_php ./vendor/bin/behat
