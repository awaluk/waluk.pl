FROM php:8.3.3-apache AS base

ENV TZ=Europe/Warsaw
RUN apt-get update -yqq
RUN apt-get install -yqq --no-install-recommends libpq-dev libzip-dev zip unzip git sudo openssh-client

RUN docker-php-ext-install pdo_mysql

COPY docker/www/apache2.conf /etc/apache2/apache2.conf
COPY docker/www/security.conf /etc/apache2/conf-enabled/security.conf
COPY docker/www/vhost.conf /etc/apache2/sites-enabled/000-default.conf
RUN a2enmod rewrite headers remoteip

RUN usermod -u 1000 www-data
RUN ssh-keyscan github.com >> /etc/ssh/ssh_known_hosts

WORKDIR /var/www

EXPOSE 80


FROM base AS dev

RUN curl -o /usr/local/bin/composer https://getcomposer.org/composer.phar && chmod +x /usr/local/bin/composer
RUN curl -sL https://deb.nodesource.com/setup_20.x | bash - && apt-get install -yqq nodejs


FROM dev AS prod-build

ENV SYMFONY_ENV=prod

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
RUN docker-php-ext-install opcache

COPY assets /var/www/assets
COPY bin /var/www/bin
COPY config /var/www/config
COPY public /var/www/public
COPY src /var/www/src
COPY templates /var/www/templates
COPY composer.json /var/www/composer.json
COPY composer.lock /var/www/composer.lock
COPY symfony.lock /var/www/symfony.lock
COPY package.json /var/www/package.json
COPY package-lock.json /var/www/package-lock.json
COPY webpack.config.js /var/www/webpack.config.js

RUN chown -R www-data /var/www
USER www-data

RUN composer install --prefer-dist --no-progress --no-dev --no-scripts --optimize-autoloader
RUN npm ci && npm run build


FROM base AS prod

ENV SYMFONY_ENV=prod

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
RUN docker-php-ext-install opcache

COPY --from=prod-build /var/www/bin /var/www/bin
COPY --from=prod-build /var/www/config /var/www/config
COPY --from=prod-build /var/www/public /var/www/public
COPY --from=prod-build /var/www/src /var/www/src
COPY --from=prod-build /var/www/templates /var/www/templates
COPY --from=prod-build /var/www/vendor /var/www/vendor
COPY --from=prod-build /var/www/composer.json /var/www/composer.json

COPY docker/www/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

RUN chown -R www-data /var/www
USER www-data

ENTRYPOINT ["/entrypoint.sh"]
