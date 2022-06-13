SHELL := /bin/bash

install: export APP_ENV=dev
install:
	docker-compose up -d
	composer install
	symfony serve -d
	symfony console d:d:c
	symfony console d:m:m --no-interaction
.PHONY: install

start: export APP_ENV=dev
start:
	docker-compose up -d
	symfony serve -d
.PHONY: start

stop: export APP_ENV=dev
stop:
	docker-compose stop
	symfony server:stop
.PHONY: stop