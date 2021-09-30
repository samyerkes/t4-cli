FROM php:7.4-cli-alpine

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY composer.json composer.json
COPY composer.lock composer.lock

RUN composer install

ENTRYPOINT [ "php", "t4" ]