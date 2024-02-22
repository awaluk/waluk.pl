FROM php:8.3.3-apache

RUN apt-get update -yqq && apt-get install -yqq --no-install-recommends libpq-dev libzip-dev zip unzip git

RUN curl -o /usr/local/bin/composer https://getcomposer.org/composer.phar && chmod +x /usr/local/bin/composer
RUN docker-php-ext-install pdo_mysql

RUN curl -sL https://deb.nodesource.com/setup_20.x | bash - && apt-get install -yqq nodejs

COPY 000-default.conf /etc/apache2/sites-available/
RUN a2enmod rewrite headers

RUN usermod -u 1000 www-data
RUN chown www-data /var/www
