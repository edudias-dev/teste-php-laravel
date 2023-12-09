#!/usr/bin/make

setup:
	@cp ./.env.example .env
	@docker-compose up -d --build
	@make install-dependencies
	
	# @make db-migrate
	# @make db-seed
	@docker-compose exec app php artisan key:generate && php artisan config:cache && php artisan cache:clear

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
