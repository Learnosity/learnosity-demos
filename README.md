# Learnosity API Demos

Jumpstart your integration of the Learnosity APIs into your learning platform.


## Overview

This repository has been designed to allow users to quickly view and interact with some of the core Learnosity APIs.

Each page shows a basic integration to a specific Learnosity API which you can utilize and learn from.

### Requirements

* PHP 7.4+
* You must be connected to the Internet to use this site

## Getting Started

The following shows you how to get the code in this repository up and running as
a stand-alone site.

First, get the code with

    git clone https://github.com/Learnosity/learnosity-demos.git

Note: To simplify the next steps, you'll need the `make` utility (usually available
in the development tools of your platform). If this option is not available to
you, see the next two sections, which show you how to start the demos site
manually.

The simple `Makefile` included with this project allows you to start one or the other
modes, by running either of the following commands from the `learnosity-demos` directory that was just created.

    make run-php  # See “Using PHP's native server” below to see what this does

You can then visit http://localhost:8080 in a browser.

Note that you must use *localhost* as the domain (not 127.0.0.1). Any port is
fine but the internal security in some of the APIs is domain restricted. So
until you contact Learnosity to whitelist specific domains, access is restricted
to *localhost*.

If port 8080 is already in use, you can specify a custom port instead, with

    make run-php PORT=8000  # Using custom port 8000

You would then be able visit http://localhost:8000 in a browser.

### Using PHP's native server

You can use PHP's built-in server to quickly get up and running.

    git clone https://github.com/Learnosity/learnosity-demos.git
    cd learnosity-demos
    php -S localhost:8080 --docroot www

## Consumer

This package comes with demo security (consumer) credentials. If you have your own consumer details (as provided by Learnosity) you may use them by editing ```lrn_config.php```


## Documentation

More API documentation is available at the [Learnosity Reference site](http://reference.learnosity.com)


## PHP dependency management using Composer

While this demonstration project ships with dependency libraries (such as the
[Learnosity SDK]) for ease of use, it is not recommended practice to do so on
production projects. The [composer] tool can be used for the purpose of
installing and upgrading third-party libraries.

See [composer-getting-started] for instructions on setting it up on your
platform. You can then try it out on this project, by running the following in
the `learnosity-demos` directory you cloned using `git` as detailed in the
previous sections.

    composer install # Reinstall dependencies as specified in the shipped composer.lock

    composer update # Upgrade dependencies according to constraints in composer.json

Note that the `make`-based instructions in the “Getting Started” section take
care of the following for you.

For simplicity, the `get-composer.php` script can be used to fetch a
local version of composer. It will be named `composer.phar`, and will have to be
called as `./composer.phar` instead of just `composer`.

If using Mac OS X, you can set up [Homebrew] to use a specific tap.

    brew tap homebrew/php
    brew install composer


[Learnosity SDK]: https://github.com/Learnosity/learnosity-sdk-php
[homebrew]: https://brew.sh/
[composer]: https://getcomposer.org
[composer-getting-started]: https://getcomposer.org/doc/00-intro.md
