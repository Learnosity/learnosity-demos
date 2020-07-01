FROM php:7.2-cli

RUN useradd -ms /bin/bash php

RUN apt-get update \
    && apt-get install -y git unzip zlib1g-dev \
    && docker-php-ext-install zip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer /usr/bin/composer /usr/bin/composer
