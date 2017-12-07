FROM php:7.1-fpm-alpine

RUN apk add --no-cache --virtual .persistent-deps \
		git \
		icu-libs \
		zlib

ENV APCU_VERSION 5.1.8

RUN set -xe \
	&& apk add --no-cache --virtual .build-deps \
		$PHPIZE_DEPS \
		icu-dev \
		zlib-dev \
		libxml2-dev \
	&& docker-php-ext-install \
		intl \
		pdo_mysql \
		zip \
		soap \
	&& pecl install \
		apcu-${APCU_VERSION} \
	&& docker-php-ext-enable --ini-name 20-apcu.ini apcu \
	&& docker-php-ext-enable --ini-name 05-opcache.ini opcache \
	&& apk del .build-deps

COPY docker/php/php.ini /usr/local/etc/php/php.ini
COPY docker/php/log.conf /usr/local/etc/php-fpm.d/zz-log.conf

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ENV COMPOSER_ALLOW_SUPERUSER 1

# Run composer installs in parallel
RUN composer global require "hirak/prestissimo:^0.3" --prefer-dist --no-progress --no-suggest --optimize-autoloader --classmap-authoritative \
	&& composer clear-cache

WORKDIR /var/www/html

COPY composer.json ./
COPY composer.lock ./


COPY app app/
COPY bin bin/
COPY src src/
COPY web web/
COPY google-cloud-auth.json ./

# Symfony thinks it is running an older version without a var directory
RUN mkdir var

# Tests
COPY tests tests/
COPY phpunit.xml.dist ./

RUN composer install --prefer-dist --no-autoloader --no-progress --no-suggest
RUN composer dump-autoload --optimize --classmap-authoritative
RUN chown -R www-data:www-data var/
USER www-data
# TODO https://github.com/api-platform/api-platform/blob/master/api/docker/php/docker-entrypoint.sh
#COPY docker/php/docker-entrypoint.sh /usr/local/bin/docker-entrypoint
#RUN chmod +x /usr/local/bin/docker-entrypoint
#ENTRYPOINT ["docker-entrypoint"]
