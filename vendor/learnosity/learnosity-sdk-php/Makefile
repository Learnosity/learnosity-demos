ARGS_PHPUNIT ?=

DOCKER := $(if $(LRN_SDK_NO_DOCKER),,$(shell which docker))

# PHP Evolution
SUPPORTED_PHP_VERSIONS = 7.1 7.2 7.3 7.4 8.0 8.1 8.2 8.3
PHP_VERSION = $(lastword ${SUPPORTED_PHP_VERSIONS})
DEBIAN_VERSION-7.1 = buster
DEBIAN_VERSION-7.2 = buster
DEBIAN_VERSION-7.3 = bullseye
DEBIAN_VERSION-7.4 = bullseye
DEBIAN_VERSION-8.0 = bullseye
DEBIAN_VERSION-def = bookworm
DEBIAN_VERSION = $(or $(DEBIAN_VERSION-$(PHP_VERSION)),$(DEBIAN_VERSION-def))
COMPOSER_VERSION-7.1 = 2.2
COMPOSER_VERSION-def = 2.7.6
COMPOSER_VERSION = $(or $(COMPOSER_VERSION-$(PHP_VERSION)),$(COMPOSER_VERSION-def))
LOCALHOST = 0.0.0.0

IMAGE = php-cli-composer:$(PHP_VERSION)-$(DEBIAN_VERSION)-$(COMPOSER_VERSION)

TARGETS = all build devbuild prodbuild \
	quickstart check-quickstart install-vendor \
	dist dist-test dist-zip release \
	lint test test-coverage test-integration-env test-unit \
	clean clean-dist clean-test clean-vendor
.PHONY: $(TARGETS)
.default: all

ifneq (,$(DOCKER))
TTYFLAGS := $(shell if [ -t 0 ] ; then echo "-it"; else echo "-t"; fi)
# Re-run the make command in a container
DKR = docker container run $(TTYFLAGS) --rm \
		-v $(CURDIR):/srv/sdk/php:z,delegated \
		-v lrn-sdk-php_cache:/root/.composer \
		-w /srv/sdk/php \
		-e LRN_SDK_NO_DOCKER=1 \
		-e ENV -e REGION -e VER \
		-p 8000:8000 \
		$(if $(findstring dev,$(ENV)),--net host) \
		$(IMAGE)

$(TARGETS): $(if $(shell docker image ls -q --filter reference=$(IMAGE)),,docker-build)
	$(DKR) make -e MAKEFLAGS="$(MAKEFLAGS)" $@

docker-build:
	docker image build \
		--progress plain \
		--build-arg PHP_VERSION=$(PHP_VERSION) \
		--build-arg DEBIAN_VERSION=$(DEBIAN_VERSION) \
		--build-arg COMPOSER_VERSION=$(COMPOSER_VERSION) \
		-t $(IMAGE) .
.PHONY: docker-build lrn-test-all lrn-test-clean


else
DIST_PREFIX = learnosity_sdk-
SRC_VERSION := $(shell git describe | sed s/^v//)
DIST = $(DIST_PREFIX)$(SRC_VERSION)

COMPOSER = composer
COMPOSER_INSTALL_FLAGS = --no-interaction --optimize-autoloader --classmap-authoritative

PHPCS= ./vendor/bin/phpcs
PHPUNIT = ./vendor/bin/phpunit

###
# quickstart rules
###
quickstart: VENDOR_FLAGS = --no-dev
quickstart: install-vendor
	cd docs/quickstart && php -S $(LOCALHOST):8000

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
#
# build a dist zip file from the distdir, THEN run the tests in the dist dir,
# to avoid polluting the distfile with dev dependencies
###
dist: dist-test

# We want to clean first before copying into the .distdir so that we have a clean copy
dist-zip: clean-test clean-dist
	mkdir -p .$(DIST) # use a hidden directory so that it doesn't get copied into itself
	cp -R * .version .$(DIST)
	mv .$(DIST) $(DIST)
	rm -rf $(DIST)/vendor/
	$(COMPOSER) install --working-dir=$(DIST) $(COMPOSER_INSTALL_FLAGS) --no-dev
	rm -rf $(DIST)/release.sh
	zip -qr $(DIST).zip $(DIST)

# run tests in the distdir
dist-test: dist-zip install-vendor
	$(PHPUNIT) --do-not-cache-result --no-logging --configuration=$(DIST)/phpunit.xml

###
# install vendor rules
###
install-vendor: composer.lock
composer.lock: composer.json
	$(COMPOSER) install $(COMPOSER_INSTALL_FLAGS) $(VENDOR_FLAGS)

clean: clean-dist clean-test clean-vendor
	rm -rf $(DIST_PREFIX)*.zip

clean-dist:
	rm -rf $(DIST_PREFIX)*/

clean-test:
	test ! -f tests/junit.xml || rm -f tests/junit.xml
	test ! -f tests/coverage.xml || rm -f tests/coverage.xml
	test ! -d tests/coverage || rm -rf tests/coverage

clean-vendor:
	rm -rf vendor
	rm -f composer.lock

# Aliases

devbuild: build
prodbuild: dist

# The following are real targets, not phony ones

vendor:
	$(COMPOSER) install $(COMPOSER_INSTALL_FLAGS)

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
endif
