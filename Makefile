PHP=php

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

run-composer: composer.phar
	./composer.phar --no-interaction install

run-php: run-composer
	cd www; php -S localhost:8080

run-vagrant:
	vagrant up

stop-vagrant:
	vagrant halt

clean:
	rm -rf vendor/
	rm -f composer.phar

devbuild: run-composer
prodbuild: run-composer
build-clean: clean
