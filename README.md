# Learnosity API Demos

Jumpstart your integration of the Learnosity API's into your learning platform.

## Overview

This repository has been designed to allow users to quickly view and interact with some of the core
Learnosity APIs.

Each page shows a basic integration to a specific Learnosity API which you can utilise and learn from.

There is also a SignatureUtils class which simplifies the generation of the security signatures for each of the types.

## Getting Started

* [Download the package](https://github.com/Learnosity/learnosity-php-examples/archive/master.zip)
* Put in a web accessible directory ^
* Test it out by browsing to index.php

^ Note that you must use *localhost* as the domain (not 127.0.0.1), any port is fine but the internal security in some of the APIs is domain restricted. So until you contact Learnosity to whitelist specific domains, access is restricted to *localhost*.

If you have PHP 5.4+ you can use the local server to quickly get up and running, no Apache/IIS is required.

```
cd learnosity-php-examples/www
php -S localhost:5000
```

Visit [localhost:5000](http://localhost:5000) in a browser.

## Consumer

This package comes with demo security (consumer) credentials. If you have your own consumer details (as provided by Learnosity) you may use them by editing ```config.php```

## Requirements

* PHP 5.3+
* You must be connected to the internet to use this site

## Documentation

More API documentation is available at the [Learnosity Docs site](http://docs.learnosity.com)
