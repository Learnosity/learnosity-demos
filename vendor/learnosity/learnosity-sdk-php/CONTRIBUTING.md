# Contributing

Contribution in the form of [PRs] are welcome.

## Why We Are No Longer Accepting Public Issues
After careful consideration, we’ve decided to discontinue accepting issues via GitHub Issues for our public repositories.

Here’s why:

- We have established support channels specifically designed to handle customer inquiries and issues.
- These channels are staffed 24/7, and we work diligently to ensure prompt responses and high-quality support.
- Maintaining and responding to GitHub Issues requires significant resources, and we are unable to provide the same level of support through this channel as we do through our dedicated support teams.
- By focusing on our dedicated support channels, we can streamline our processes and offer a more effective and responsive service to our users.

For any issues or support needs, please use the existing support channels. This will help us provide you with the best possible assistance in a timely manner.

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
