#!/usr/bin/make
start:
	@make setup

setup:
	@cp ./.env.example .env
	@docker-compose up -d --build
	@make install-dependencies

	@make db-migrate
	@make db-seed
	@docker-compose run app php artisan key:generate
	@docker-compose run app php artisan config:cache
	@docker-compose run app php artisan cache:clear

install-dependencies:
	@docker-compose exec app composer install

build:
	@docker-compose build

update:
	@docker-compose run app composer update

db-migrate:
	@docker-compose run app php artisan migrate

db-seed:
	@docker-compose run app php artisan db:seed

unit-tests:
	@docker-compose run app php ./vendor/bin/phpunit --no-coverage --testdox

queue-work:
	@docker-compose run app php artisan queue:work --queue=post-processor-file
