all: run-php

lint:
	# check for php syntax errors
	find src www -type f -name '*.php' -exec php -l {} \; | (! grep -v "No syntax errors detected" )

run-php:
	cd www; php -S localhost:8080

run-vagrant:
	vagrant up
