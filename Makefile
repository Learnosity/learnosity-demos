lint:
	# check for php syntax errors
	find src www -type f -name '*.php' -exec php -l {} \; | (! grep -v "No syntax errors detected" )
