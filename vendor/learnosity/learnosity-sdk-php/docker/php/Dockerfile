ARG PHP_VERSION=8.3
ARG DEBIAN_VERSION=bookworm
ARG COMPOSER_VERSION=2.7.6

FROM php:${PHP_VERSION}-fpm-${DEBIAN_VERSION}

# Install necessary dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    git=1:2.* \
    libzip-dev=1.* \
    unzip=6.0* \
    zip=3.0* \
    && docker-php-ext-install zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Configure PHP-FPM to listen on TCP/IP
RUN sed -i 's/listen = \/run\/php-fpm.sock/listen = 127.0.0.1:9000/g' /usr/local/etc/php-fpm.d/www.conf

WORKDIR /var/www/html

EXPOSE 9000

CMD ["php-fpm"]
