FROM php:8.3.3-apache AS base

RUN apt-get update -yqq
RUN apt-get install -yqq --no-install-recommends libpq-dev libzip-dev zip unzip git sudo openssh-client

RUN docker-php-ext-install pdo_mysql

COPY docker/www/remoteip.conf /etc/apache2/conf-enabled/remoteip.conf
COPY docker/www/security.conf /etc/apache2/conf-enabled/security.conf
COPY docker/www/vhost.conf /etc/apache2/sites-enabled/000-default.conf
RUN a2enmod rewrite headers remoteip

RUN usermod -u 1000 www-data

WORKDIR /var/www

EXPOSE 80


FROM base AS dev

RUN curl -o /usr/local/bin/composer https://getcomposer.org/composer.phar && chmod +x /usr/local/bin/composer

RUN curl -sL https://deb.nodesource.com/setup_20.x | bash - && apt-get install -yqq nodejs


FROM base AS prod

ENV SYMFONY_ENV=prod

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
RUN docker-php-ext-install opcache

COPY docker/www/entrypoint.sh /entrypoint.sh
RUN chmod -v +x /entrypoint.sh

COPY bin /var/www/bin
COPY config /var/www/config
COPY public /var/www/public
COPY src /var/www/src
COPY templates /var/www/templates
COPY var /var/www/var
COPY vendor /var/www/vendor
COPY composer.json /var/www/composer.json

RUN ssh-keyscan github.com >> /etc/ssh/ssh_known_hosts

RUN chown -R www-data /var/www
USER www-data

ENTRYPOINT ["/entrypoint.sh"]
