FROM php:7.2-fpm

# standard php api layer
# version 2020/03/16

RUN apt-get update \
    && apt-get install -y \
        default-mysql-client \
        libpq-dev \
    && pear channel-discover pear.nrk.io \
    && pear install nrk/Predis \
    && pecl install apcu_bc \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure pdo_mysql --with-pdo-mysql=mysqlnd \
    && docker-php-ext-configure mysqli \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install -j$(nproc) \
    pdo_mysql \
    mysqli \
    pdo_pgsql pgsql \
    opcache \
    && pecl install xdebug \
    && rm -rf /var/lib/apt/lists/*


COPY ./*.ini $PHP_INI_DIR/conf.d/
COPY ./config/99-xdebug.ini /etc/php-addons/xdebug/
