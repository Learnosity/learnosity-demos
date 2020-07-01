PHP=php

YARN=yarn
NPM=npm
COMPOSER_INSTALL=
NODE_CLI_CONTAINER=node
PHP_CLI_CONTAINER=php

LDE = $(shell command -v lde)

ifneq ("$(LDE)","")
    ENV=dev
	COMPOSE=docker-compose -f docker-compose.yml
	CLI_COMPOSE=$(COMPOSE) -f ./lde_config/docker-compose.cli.yml run --rm --service-ports
	NODE_CMD=$(CLI_COMPOSE) $(NODE_CLI_CONTAINER)
	PHP_CMD=$(CLI_COMPOSE) $(PHP_CLI_CONTAINER)
	YARN=$(NODE_CMD) yarn
	YARN_INSTALL=$(YARN) install
	COMPOSER=$(CLI_COMPOSE) $(PHP_CLI_CONTAINER) composer
	COMPOSER_INSTALL=$(COMPOSER) install --prefer-dist --classmap-authoritative --no-progress
endif
# ======================================
# Codebuild Env
# ======================================
ifneq ($(origin ENV_CODEBUILD),undefined)
	ENV=dev
	BUILD_ENV=codebuild
	CLI_COMPOSE=docker-compose --project-directory . -f ./lde_config/docker-compose.cli.yml run -u root --rm --service-ports
	NODE_CMD=$(CLI_COMPOSE) $(NODE_CLI_CONTAINER)
	PHP_CMD=$(CLI_COMPOSE) $(PHP_CLI_CONTAINER)
	YARN=$(NODE_CMD) yarn
	YARN_INSTALL=$(YARN) install --ignore-optional --unsafe-perm=true --allow-root
	COMPOSER=$(PHP_CMD) composer
	COMPOSER_INSTALL=docker-compose --project-directory . -f ./lde_config/docker-compose.cli.yml run -u root --rm --service-ports --entrypoint sh php -c "composer config -g github-oauth.github.com $$COMPOSER_KEY; composer install --prefer-dist --classmap-authoritative --no-progress"
endif

all: run-php

lint:
	# check for php syntax errors
	find src www -type f -name '*.php' -exec php -l {} \; | (! grep -v "No syntax errors detected" )

all: run-composer
	@echo "Environment ready; you can now start the demos with"
	@echo "	   make run-php"

get-composer: composer.phar
composer.phar:
	$(PHP) get-composer.php

ifneq ($(or $(LDE), $(origin ENV_CODEBUILD)), undefined)
run-composer:
	$(COMPOSER_INSTALL)
else
run-composer: composer.phar
	./composer.phar --no-interaction install
endif

run-php: run-composer
	cd www; php -S localhost:8080

run-vagrant:
	vagrant up

stop-vagrant:
	vagrant halt

ifneq ($(or $(LDE), $(origin ENV_CODEBUILD)), undefined)
update-assets:
	$(YARN) install
	$(NODE_CMD) ./node_modules/.bin/gulp
else
update-assets:
	npm install
	./node_modules/.bin/gulp
endif

clean:
	rm -rf vendor/
	rm -f composer.phar
	rm -rf node_modules

devbuild: run-composer update-assets
prodbuild: run-composer
build-clean: clean

# ======================================
# LDE targets - specific to Learnosity LDE framework
# ======================================

lde-build:
	lde build

lde: lde-build devbuild

# ======================================
# LDC targets - specific to Learnosity LDC environment
# ======================================
image-tag-exists: export BUILD_TAG ?= $(shell git log --pretty=format:'%H' -n 1)
image-tag-exists: EXISTS_CHECK = $(strip $(shell aws ecr describe-images --registry-id=$(REGISTRY_ID) --repository-name=$(REPO_NAME)/site-demos-fpm --image-ids=imageTag=$(BUILD_TAG) 2> /dev/null))
image-tag-exists:
	@if [ -n '${EXISTS_CHECK}' ]; then echo "$(BUILD_TAG) tags already exist for this repo..."; exit 1; fi

build-ldc: devbuild
	# LDE Build
	docker build -f ./lde_config/lde/nginx/Dockerfile -t site-demos_nginx:latest --no-cache ./lde_config/lde/nginx
	docker build -f ./lde_config/lde/php-fpm/Dockerfile -t site-demos_php-fpm:latest --no-cache ./lde_config/lde/php-fpm
	# LDC Build
	docker build -f ./lde_config/ldc/nginx/Dockerfile -t site-demos-nginx --no-cache .
	docker build -f ./lde_config/ldc/php-fpm/Dockerfile -t site-demos-fpm --no-cache .

dist-%: export BUILD_TAG ?= $(shell git log --pretty=format:'%H' -n 1)
dist-%: image-tag-exists build-%
	docker tag site-demos-nginx:latest $(DOCKER_REPO)/site-demos-nginx:${BUILD_TAG}
	docker tag site-demos-fpm:latest $(DOCKER_REPO)/site-demos-fpm:${BUILD_TAG}

	docker push $(DOCKER_REPO)/site-demos-nginx:${BUILD_TAG}
	docker push $(DOCKER_REPO)/site-demos-fpm:${BUILD_TAG}

deploy-%: export BUILD_TAG ?= $(shell git log --pretty=format:'%H' -n 1)
deploy-%:
	ldc app --config env_$(*).yml --tag-version ${BUILD_TAG} --app-config ./lde_config/dist/site-demos-$(*).yml --yes
