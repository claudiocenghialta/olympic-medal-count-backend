include .env

default: up

COMPOSER_ROOT ?= /var/www/html
DRUPAL_ROOT ?= /var/www/html/web
LAMP = -f docker-compose.yml

UNAME_S := $(shell uname -s)
ifeq ($(UNAME_S),Darwin)
	LAMP := $(LAMP) -f docker-compose.override.mac.yml
endif

ifeq ($(TRAEFIK),ON)
	LAMP := $(LAMP) -f docker-compose.override.traefik.yml
endif

ifeq ($(XDEBUG),ON)
	LAMP := $(LAMP) -f docker-compose.override.xdebug.yml
endif

ifneq ("$(wildcard docker-compose.override.yml)","")
    LAMP := $(LAMP) -f docker-compose.override.yml
endif

## help	:	Print commands help.
.PHONY: help
ifneq (,$(wildcard docker.mk))
help : docker.mk
	@sed -n 's/^##//p' $<
else
help : Makefile
	@sed -n 's/^##//p' $<
endif

## up	:	Start up containers.
.PHONY: up
up:
	@echo "Starting up containers for $(PROJECT_NAME)..."
	docker-compose $(LAMP) pull
	docker-compose $(LAMP) up -d --remove-orphans

## down	:	Stop containers.
.PHONY: down
down: stop

## start	:	Start containers without updating.
.PHONY: start
start:
	@echo "Starting containers for $(PROJECT_NAME) from where you left off..."
	@docker-compose $(LAMP) start

## stop	:	Stop containers.
.PHONY: stop
stop:
	@echo "Stopping containers for $(PROJECT_NAME)..."
	@docker-compose $(LAMP) stop

## prune	:	Remove containers and their volumes.
##		You can optionally pass an argument with the service name to prune single container
##		prune mariadb	: Prune `mariadb` container and remove its volumes.
##		prune mariadb solr	: Prune `mariadb` and `solr` containers and remove their volumes.
.PHONY: prune
prune:
	@echo "Removing containers for $(PROJECT_NAME)..."
	@docker-compose $(LAMP) down -v $(filter-out $@,$(MAKECMDGOALS))

## ps	:	List running containers.
.PHONY: ps
ps:
	@docker ps --filter name='$(PROJECT_NAME)*'

## shell	:	Access `php` container via shell.
.PHONY: shell
shell:
	docker exec -ti -e COLUMNS=$(shell tput cols) -e LINES=$(shell tput lines) $(shell docker ps --filter name='$(PROJECT_NAME)_php' --format "{{ .ID }}") sh

## composer:	Executes `composer` command in a specified `COMPOSER_ROOT` directory (default is `/var/www/html`).
##		To use "--flag" arguments include them in quotation marks.
##		For example: make composer "update drupal/core --with-dependencies"
.PHONY: composer
composer:
	docker exec $(shell docker ps --filter name='^/$(PROJECT_NAME)_php' --format "{{ .ID }}") composer --working-dir=$(COMPOSER_ROOT) $(filter-out $@,$(MAKECMDGOALS))

## drush	:	Executes `drush` command in a specified `DRUPAL_ROOT` directory (default is `/var/www/html/web`).
##		To use "--flag" arguments include them in quotation marks.
##		For example: make drush "watchdog:show --type=cron"
.PHONY: drush
drush:
	docker exec $(shell docker ps --filter name='^/$(PROJECT_NAME)_php' --format "{{ .ID }}") drush -r $(DRUPAL_ROOT) $(filter-out $@,$(MAKECMDGOALS))

## exec	:	Executes command in container php.
##		To use "--flag" arguments include them in quotation marks.
##		For example: make exec "echo ciao!"
.PHONY: exec
exec:
	docker exec -t $(shell docker ps --filter name='^/$(PROJECT_NAME)_php' --format "{{ .ID }}") $(filter-out $@,$(MAKECMDGOALS))

## logs	:	View containers logs.
##		You can optinally pass an argument with the service name to limit logs
##		logs php	: View `php` container logs.
##		logs nginx php	: View `nginx` and `php` containers logs.
.PHONY: logs
logs:
	@docker-compose logs -f $(filter-out $@,$(MAKECMDGOALS))

## analyze:	Analyze code project.
##		You can analyze code with custom docker container that use phpqa.
.PHONY: analyze
analyze:
	docker run -it -u $$(id -u) --rm -v "`pwd`/../":/app lucacracco/phpqa:version-1.1 phpqa --config=phpqa


## make Doctrine migrations on DB
.PHONY: migrate
migrate:
	docker exec -ti -e COLUMNS=$(shell tput cols) -e LINES=$(shell tput lines) $(shell docker ps --filter name='$(PROJECT_NAME)_php' --format "{{ .ID }}") php bin/console Doctrin:migrations:migrate -n

## Load data fixture on DB
.PHONY: load
load:
	docker exec -ti -e COLUMNS=$(shell tput cols) -e LINES=$(shell tput lines) $(shell docker ps --filter name='$(PROJECT_NAME)_php' --format "{{ .ID }}") php bin/console doctrine:fixtures:load -n

## launch tests
.PHONY: test
test:
	docker exec -ti -e COLUMNS=$(shell tput cols) -e LINES=$(shell tput lines) $(shell docker ps --filter name='$(PROJECT_NAME)_php' --format "{{ .ID }}") php ./vendor/bin/phpunit --debug
