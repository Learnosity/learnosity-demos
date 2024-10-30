ARG PHP_VERSION=8.3
ARG DEBIAN_VERSION=bookworm
ARG COMPOSER_VERSION=2.7.6

FROM composer:${COMPOSER_VERSION} as composer

FROM php:${PHP_VERSION}-cli-${DEBIAN_VERSION}

COPY --from=composer /usr/bin/composer /usr/local/bin/composer

RUN apt-get update && apt-get install -y --no-install-recommends \
        git=1:2.* libzip-dev=1.* unzip=6.0* zip=3.0* \
  && docker-php-ext-install zip \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/*
