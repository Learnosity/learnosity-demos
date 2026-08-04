ARGS_PHPUNIT ?=

DOCKER := $(if $(LRN_SDK_NO_DOCKER),,$(shell which docker))
DOCKER_COMPOSE := docker compose

# PHP Evolution
SUPPORTED_PHP_VERSIONS = 8.2 8.3 8.4 8.5
PHP_VERSION ?= $(lastword ${SUPPORTED_PHP_VERSIONS})
DEBIAN_VERSION-7.1 = buster
DEBIAN_VERSION-7.2 = buster
DEBIAN_VERSION-7.3 = bullseye
DEBIAN_VERSION-7.4 = bullseye
DEBIAN_VERSION-8.0 = bullseye
DEBIAN_VERSION-def = bookworm
DEBIAN_VERSION ?= $(or $(DEBIAN_VERSION-$(PHP_VERSION)),$(DEBIAN_VERSION-def))
COMPOSER_VERSION-7.1 = 2.2
COMPOSER_VERSION-def = 2.7.6
COMPOSER_VERSION ?= $(or $(COMPOSER_VERSION-$(PHP_VERSION)),$(COMPOSER_VERSION-def))

TARGETS = all build devbuild prodbuild \
	quickstart check-quickstart install-vendor \
	dist dist-test dist-zip release \
	lint test test-coverage test-integration-env test-unit \
	clean clean-dist clean-test clean-vendor

.PHONY: $(TARGETS)
.default: all

docker-build: install-vendor
	$(DOCKER_COMPOSE) build php nginx

.PHONY: docker-build

# Local development targets without Docker
DIST_PREFIX = learnosity_sdk-
SRC_VERSION := $(shell git describe | sed s/^v//)
DIST = $(DIST_PREFIX)$(SRC_VERSION)

COMPOSER = composer
COMPOSER_INSTALL_FLAGS = --no-interaction --optimize-autoloader --classmap-authoritative

PHPCS= ./vendor/bin/phpcs
PHPUNIT = ./vendor/bin/phpunit

quickstart: $(if $(DOCKER),docker-build) $(if $(DOCKER),docker,local)-quickstart

docker-quickstart: VENDOR_FLAGS = --no-dev
docker-quickstart: install-vendor
	$(DOCKER_COMPOSE) up -d

local-quickstart: VENDOR_FLAGS = --no-dev
local-quickstart: install-vendor
	php -S localhost:8000 -t docs/quickstart

check-quickstart: vendor/autoload.php
	$(COMPOSER) install $(COMPOSER_INSTALL_FLAGS) --no-dev;

###
# internal tooling rules
####
build: install-vendor

devbuild: build

prodbuild: VENDOR_FLAGS = --no-dev
prodbuild: install-vendor

release:
	@./release.sh

lint: build
	$(PHPCS) src

test: build
	$(PHPUNIT) $(if $(subst 7.1,,$(PHP_TARGET)),--do-not-cache-result) $(ARGS_PHPUNIT)

test-coverage: build
	XDEBUG_MODE=coverage $(PHPUNIT) --do-not-cache-result $(ARGS_PHPUNIT)

test-unit: build
	$(PHPUNIT) --do-not-cache-result --testsuite unit $(ARGS_PHPUNIT)

test-integration-env: build
	$(PHPUNIT) --do-not-cache-result --testsuite integration $(ARGS_PHPUNIT)

###
# dist rules
###
dist: dist-test

dist-zip: clean-test clean-dist
	mkdir -p .$(DIST)
	cp -R * .version .$(DIST)
	mv .$(DIST) $(DIST)
	rm -rf $(DIST)/vendor/
	$(COMPOSER) install --working-dir=$(DIST) $(COMPOSER_INSTALL_FLAGS) --no-dev
	rm -rf $(DIST)/release.sh
	zip -qr $(DIST).zip $(DIST)

dist-test: dist-zip install-vendor
	cd $(DIST) && composer install $(COMPOSER_INSTALL_FLAGS)
	cd $(DIST) && ./vendor/bin/phpunit --do-not-cache-result --no-logging

###
# install vendor rules
###
install-vendor: composer.lock
composer.lock: composer.json
	$(COMPOSER) install $(COMPOSER_INSTALL_FLAGS) $(VENDOR_FLAGS)

clean: clean-dist clean-test clean-vendor
	rm -rf $(DIST_PREFIX)*.zip
	$(DOCKER_COMPOSE) down -v

clean-dist:
	rm -rf $(DIST_PREFIX)*/

clean-test:
	test ! -f tests/junit.xml || rm -f tests/junit.xml
	test ! -f tests/coverage.xml || rm -f tests/coverage.xml
	test ! -d tests/coverage || rm -rf tests/coverage

clean-vendor:
	rm -rf vendor
	rm -f composer.lock

# Package contents
PKG_CONTENTS = .version \
	CONTRIBUTING.md LICENSE.md README.md REFERENCE.md ChangeLog.md \
	composer.json bootstrap.php phpunit.xml \
	docs src

$(DIST):
	mkdir -p $(DIST)
	cp -R $(PKG_CONTENTS) $(DIST)

$(DIST)/vendor: $(DIST)
	cd $(DIST) && $(COMPOSER) install $(COMPOSER_INSTALL_FLAGS) --no-dev

$(DIST).zip: $(DIST)/vendor
	zip -qr $(DIST).zip $(DIST)
