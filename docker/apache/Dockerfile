FROM php:7.3-apache

RUN a2enmod rewrite

RUN apt-get update \
  && apt-get install -y libzip-dev git wget unzip --no-install-recommends \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN docker-php-ext-install pdo zip opcache

RUN wget https://getcomposer.org/download/2.0.9/composer.phar \
    && mv composer.phar /usr/bin/composer && chmod +x /usr/bin/composer

COPY docker/apache/php.ini "$PHP_INI_DIR/php.ini"

COPY docker/apache/apache.conf /etc/apache2/sites-enabled/000-default.conf
COPY docker/apache/entrypoint.sh /entrypoint.sh

WORKDIR /var/www/html

COPY composer.json ./
COPY composer.lock ./

COPY app app/
COPY bin bin/
COPY src src/
COPY web web/
COPY google-cloud-auth.json ./

COPY tests tests/
COPY phpunit.xml.dist ./

RUN mkdir -p var/data

RUN chmod +x /entrypoint.sh
RUN chown -R www-data:www-data .

CMD ["apache2-foreground"]
USER www-data
ENTRYPOINT ["/entrypoint.sh"]
