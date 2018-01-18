WDIO = ./node_modules/.bin/wdio
NODE = node

REGION="all"
ENV="prod"

ENV_VARS = _REGION=$(REGION) \
	_ENV=$(ENV)

MANUAL_TESTPAGE_PORT="$(shell node tests/ui/lib/getPortConfig.js key=manualTestpagePort)"
SELENIUM_TESTPAGE_PORT="$(shell node tests/ui/lib/getPortConfig.js key=seleniumTestpagePort)"

devbuild: build-npm-dev

test-ui-env: build-npm-dev
	@echo "\nBy default this suite runs against va, au and or (for data api)"
	@echo "To run against a specific region use: 'make test-ui-env REGION=-au.learnosity.com'"
	@echo "To run against a specific env use: 'make test-ui-env ENV=staging'\n"
	# $(ENV_VARS) $(NODE) tests/ui/lib/provisionContent.js
	$(ENV_VARS) $(WDIO) tests/ui/wdio.conf.js

# Clean built assets
build-clean:
	rm -rf node_modules

build-npm-dev:
	if which yarn >/dev/null; then yarn install --ignore-optional; else npm install; fi
