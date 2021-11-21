FROM php:7.4-fpm

RUN apt-get update && apt-get install -y curl zip unzip

RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/

RUN install-php-extensions gd intl mysqli pdo_mysql soap zip

RUN curl -sS https://getcomposer.org/installer | php \
    && chmod +x composer.phar && mv composer.phar /usr/local/bin/composer
