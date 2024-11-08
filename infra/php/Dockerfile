FROM php:8.1-fpm

ENV COMPOSER_ALLOW_SUPERUSER=1 \
  COMPOSER_HOME=/composer

COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

RUN apt-get update && \
  apt-get -y install --no-install-recommends git unzip libzip-dev libicu-dev libonig-dev && \
  apt-get clean && \
  rm -rf /var/lib/apt/lists/* && \
  docker-php-ext-install intl pdo_mysql zip bcmath

RUN apt-get update && apt-get install -y \
  libssl-dev \
  pkg-config \
  && pecl install mongodb \
  && docker-php-ext-enable mongodb

COPY ./php.ini /usr/local/etc/php/php.ini

COPY --from=node:12.20 /usr/local/bin /usr/local/bin
COPY --from=node:12.20 /usr/local/lib /usr/local/lib

WORKDIR /data