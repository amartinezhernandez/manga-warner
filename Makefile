DOCKER_NAMESPACE := $(shell basename $(CURDIR) | tr A-Z a-z)
DOCKER_COMPOSE = docker-compose -p ${DOCKER_NAMESPACE} --project-directory ${PWD}
PHP_SERVICE = php

.PHONY: start
start: ## Start this project
	. ${PWD}/.env.local && $(DOCKER_COMPOSE) up --remove-orphans
.PHONY: bash
bash: ## Launch PHP_SERVICE shell console
	$(DOCKER_COMPOSE) exec ${PHP_SERVICE} bash
