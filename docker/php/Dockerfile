FROM php:8.1-fpm-alpine

RUN apk --update add vim curl make openssh

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app

EXPOSE 9000

CMD ["php-fpm"]
