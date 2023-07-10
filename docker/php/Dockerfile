# https://hub.docker.com/_/php?tab=tags
FROM php:8.2.7-cli-alpine

RUN apk add postgresql-dev
RUN docker-php-ext-install pdo_pgsql
RUN docker-php-ext-install pcntl

RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS linux-headers
RUN pecl install xdebug
COPY xdebug.ini /usr/local/etc/php/conf.d/
RUN apk del .build-deps

CMD ["php", "-v"]
