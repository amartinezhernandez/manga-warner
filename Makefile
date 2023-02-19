DOCKER_NAMESPACE := $(shell basename $(CURDIR) | tr A-Z a-z)
DOCKER_COMPOSE = docker-compose -p ${DOCKER_NAMESPACE} --project-directory ${PWD}
PHP_SERVICE = php
USER_ID:=$(shell id -u)
GROUP_ID:=$(shell id -g)
RUN_APP = $(DOCKER_COMPOSE) run --user="${USER_ID}:${GROUP_ID}" --rm php sh -c

.PHONY: start
start: ## Start this project
	. ${PWD}/.env.local && $(DOCKER_COMPOSE) up -d --remove-orphans
.PHONY: bash
bash: ## Launch PHP_SERVICE shell console
	$(DOCKER_COMPOSE) exec ${PHP_SERVICE} bash

.PHONY: db-migrate
db-migrate: ## Launch all migrations
	$(RUN_APP) "php ./bin/console doctrine:migrations:migrate --no-interaction"

.PHONY: db-diff
db-diff: ## Create an empty migration
	$(RUN_APP) "php ./bin/console doctrine:migrations:diff"
