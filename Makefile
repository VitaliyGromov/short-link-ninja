SHELL := /bin/bash

DC := docker compose
APP_SERVICE := app

.PHONY: env up down install key migrate scribe test-up

env:
	@if [ -f .env ]; then \
		echo ".env already exists"; \
	else \
		cp .env.example .env && echo ".env created from .env.example"; \
	fi

up:
	$(DC) up --build -d

down:
	$(DC) down

install:
	$(DC) exec -T $(APP_SERVICE) composer install --no-interaction --prefer-dist

key:
	$(DC) exec -T $(APP_SERVICE) php artisan key:generate

migrate:
	$(DC) exec -T $(APP_SERVICE) php artisan migrate --force

scribe:
	$(DC) exec -T $(APP_SERVICE) php artisan scribe:generate

shell:
	$(DC) exec -it $(APP_SERVICE) bash

seed:
	$(DC) exec -T $(APP_SERVICE) php artisan db:seed

test-up:
	$(DC) down -v --remove-orphans
	$(MAKE) env
	$(MAKE) up
	$(MAKE) install
	$(MAKE) key
	$(MAKE) migrate
	$(MAKE) seed

pint:
	$(DC) exec -T $(APP_SERVICE) vendor/bin/pint