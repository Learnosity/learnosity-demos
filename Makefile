PHP=php
PORT=8080

all: run-php

lint:
	# check for php syntax errors
	find src www -type f -name '*.php' -exec php -l {} \; | (! grep -v "No syntax errors detected" )

all: run-composer
	@echo "Environment ready; you can now start the demos with"
	@echo "	   make run-php"

get-composer: composer.phar
composer.phar:
	${PHP} get-composer.php

run-composer: composer.phar
	./composer.phar --no-interaction install

run-php: run-composer
	php -S localhost:${PORT} --docroot www

run-vagrant:
	vagrant up

stop-vagrant:
	vagrant halt

update-assets:
	npm install
	./node_modules/.bin/gulp

clean:
	rm -rf vendor/
	rm -f composer.phar
	rm -rf node_modules

devbuild: run-composer
prodbuild: run-composer
build-clean: clean
