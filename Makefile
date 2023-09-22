OS := $(shell uname)

install:
	sh ./install.sh

migrate:
	docker-compose exec -T symfony-example-php php bin/console doctrine:migrations:diff --no-interaction
	docker-compose exec -T symfony-example-php php bin/console doctrine:migrations:migrate --no-interaction

diff_migrations:
	docker-compose exec -T symfony-example-php php bin/console doctrine:migrations:diff --no-interaction

migrations:
	docker-compose exec -T symfony-example-php php bin/console doctrine:migrations:migrate --no-interaction

composer_install:
	COMPOSER_ALLOW_SUPERUSER=1 docker-compose exec -T symfony-example-php composer self-update
	COMPOSER_ALLOW_SUPERUSER=1 docker-compose exec -T symfony-example-php composer install --no-interaction --classmap-authoritative --optimize-autoloader

composer_update:
	COMPOSER_ALLOW_SUPERUSER=1 docker-compose exec -T symfony-example-php composer self-update
	COMPOSER_ALLOW_SUPERUSER=1 docker-compose exec -T symfony-example-php composer update --no-interaction --classmap-authoritative --optimize-autoloader

build_dev_local:
	docker-compose -f docker-compose.yaml -f docker-compose-dev.local.yaml build

start_dev_local:
ifeq ($(OS),Darwin)
	docker volume create --name=symfony-example-api-vendor-sync
	docker volume create --name=symfony-example-api-app-sync
	docker-compose -f docker-compose.yaml -f docker-compose-dev.local.yaml up -d --force-recreate
	docker-sync start -f
endif

stop_dev_local:
ifeq ($(OS),Darwin)
	docker-compose stop
	docker-sync stop
endif

sync_clean:
ifeq ($(OS),Darwin)
	docker-sync clean
endif

build_dev:
	docker-compose -f docker-compose.yaml -f docker-compose-dev.yaml build

start_dev:
	docker-compose -f docker-compose.yaml -f docker-compose-dev.yaml up -d

execphp:
	docker-compose exec symfony-example-php bash

execdb:
	docker-compose exec symfony-example-mysql bash

copy_vendor:
	rm -r ./vendor
	docker-compose cp symfony-example-php:/app/vendor/ ./vendor

run_tests:
	docker-compose exec -T symfony-example-php-test vendor/bin/phpunit

run_phpstan:
	docker-compose exec -T symfony-example-php vendor/bin/phpstan analyse

run_ecs:
	docker-compose exec -T symfony-example-php vendor/bin/ecs check src/ --fix

build_test_local:
	docker-compose -f docker-compose-test-local.yaml build

start_test_local:
ifeq ($(OS),Darwin)
	docker volume create --name=symfony-example-api-app-sync
	docker-compose -f docker-compose-test-local.yaml up -d
	docker-sync start -f
else
	docker-compose -f docker-compose-test.yaml up -d
endif

stop_test_local:
ifeq ($(OS),Darwin)
	docker-compose -f docker-compose-test-local.yaml down
	docker-sync stop
else
	docker-compose -f docker-compose-test-local.yaml down
endif

install_test:
	sh ./install-test.sh

execphp_test:
	docker-compose exec symfony-example-php-test bash
