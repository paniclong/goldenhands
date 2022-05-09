FROM php:8.1-fpm-alpine

RUN set -ex \
    && apk --update --no-cache add vim curl make openssh postgresql-dev autoconf

RUN apk add gcc g++ make

RUN pecl install redis-5.3.7

RUN docker-php-ext-install pdo pdo_pgsql opcache
RUN docker-php-ext-enable redis

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app

EXPOSE 9000

CMD ["php-fpm"]
