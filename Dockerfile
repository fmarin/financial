FROM php:7.4.19-fpm-alpine
WORKDIR /app

RUN apk --update upgrade \
    && apk add --no-cache autoconf automake make gcc g++ icu-dev rabbitmq-c rabbitmq-c-dev \
    && pecl install amqp \
    && pecl install apcu \
    && pecl install xdebug \
    && docker-php-ext-install -j$(nproc) \
        bcmath \
        opcache \
        intl \
        pdo_mysql \
    && docker-php-ext-enable \
        amqp \
        apcu \
        opcache

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=2.0.13

RUN apk --no-cache add shadow && usermod -u 1000 www-data

COPY etc/infrastructure/php/ /usr/local/etc/php/
