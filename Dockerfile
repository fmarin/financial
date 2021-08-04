FROM php:7.4.19-fpm-alpine
WORKDIR /app

#Download the desired package(s)
RUN curl -O https://download.microsoft.com/download/e/4/e/e4e67866-dffd-428c-aac7-8d28ddafb39b/msodbcsql17_17.7.2.1-1_amd64.apk \
    && curl -O https://download.microsoft.com/download/e/4/e/e4e67866-dffd-428c-aac7-8d28ddafb39b/mssql-tools_17.7.1.1-1_amd64.apk

#Install the package(s)
RUN apk add --allow-untrusted msodbcsql17_17.7.2.1-1_amd64.apk \
    && apk add --allow-untrusted mssql-tools_17.7.1.1-1_amd64.apk

RUN apk --update upgrade \
    && apk add --no-cache autoconf automake make gcc g++ icu-dev rabbitmq-c rabbitmq-c-dev unixodbc-dev \
    && pecl install amqp \
    && pecl install apcu \
    && pecl install xdebug \
    && pecl install sqlsrv \
    && pecl install pdo_sqlsrv \
    && docker-php-ext-install -j$(nproc) \
        bcmath \
        opcache \
        intl \
        pdo_mysql \
    && docker-php-ext-enable --ini-name 30-sqlsrv.ini sqlsrv \
    && docker-php-ext-enable --ini-name 35-pdo_sqlsrv.ini pdo_sqlsrv \
    && docker-php-ext-enable \
        amqp \
        apcu \
        opcache \
        xdebug

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=2.0.13

RUN apk --no-cache add shadow && usermod -u 1000 www-data
