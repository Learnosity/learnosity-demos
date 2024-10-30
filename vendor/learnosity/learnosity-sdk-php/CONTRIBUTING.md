# Contributing

Contribution in the form of [Issues] and [PRs] are welcome.

## Development

You can ask [Composer] to download the latest sources

    composer create-project --prefer-source learnosity/learnosity-sdk-php

or get it manually with Git.

    git clone git@github.com:Learnosity/learnosity-sdk-php.git

If you don't have an SSH key loaded into github you can clone via HTTPS (not recommended)

    git clone https://github.com/Learnosity/learnosity-sdk-php.git

In the second case, you'll need to install the dependencies afterwards.

    composer install

## Tests

Test can be run from a development checkout with

     ./vendor/bin/phpunit

[Issues]: https://github.com/Learnosity/learnosity-sdk-php/issues/new
[PRs]: https://github.com/Learnosity/learnosity-sdk-php/compare
[Composer]: https://getcomposer.org/

## Creating a new release

Run `make release`.

This requires GNU-flavoured UNIX tools (particularly `gsed`). If those are not the default on your system, you'll need to install them, e.g. for OS X,

    brew install gsed coreutils