VERSION=$(shell git describe | sed s/^v//)
DIST_PREFIX=learnosity_sdk-
DIST=$(DIST_PREFIX)$(VERSION)

COMPOSER=composer
COMPOSER_INSTALL_FLAGS=--no-suggest --no-interaction

PHPUNIT=./vendor/bin/phpunit

all: test dist

###
# internal tooling rules
####
devbuild: install-vendor-dev

prodbuild: dist

release:
	@./release.sh

test: test-unit test-integration-env

test-unit:
	$(PHPUNIT) --testsuite unit

test-integration-env:
	$(PHPUNIT) --testsuite integration

test-dist: dist-test

build-clean: clean

###
# dist rules
#
# build a dist zip file from the distdir, THEN run the tests in the dist dir,
# to avoid polluting the distfile with dev dependencies
###
dist: dist-zip dist-test

# We want to clean first before copying into the .distdir so that we have a clean copy
dist-zip: clean
	mkdir -p .$(DIST) # use a hidden directory so that it doesn't get copied into itself
	cp -R * .$(DIST)
	mv .$(DIST) $(DIST)
	$(MAKE) -C $(DIST) install-vendor # install the composer vendor inside the dist dir
	rm $(DIST)/Makefile # this step needs to be the last step before zipping
	zip -qr $(DIST).zip $(DIST)

# run tests in the distdir
dist-test: dist-zip install-vendor-dev
	$(PHPUNIT) -c $(DIST)/phpunit.xml

###
# install vendor rules
###
install-vendor:
	$(COMPOSER) install $(COMPOSER_INSTALL_FLAGS) --no-dev

install-vendor-dev:
	$(COMPOSER) install $(COMPOSER_INSTALL_FLAGS)

###
# cleaning rules
###
clean: clean-dist clean-test clean-vendor
	rm -rf $(DIST_PREFIX)*.zip

clean-dist:
	rm -rf $(DIST_PREFIX)*/

clean-test:
	rm -f src/tests/junit.xml

clean-vendor:
	test ! -d vendor || rm -r vendor
