#!/bin/bash

sleep 3
chown -R www-data:www-data /var/www

sudo -u www-data php bin/console app:load:posts
sudo -u www-data php bin/console app:build:blog-rss
sudo -u www-data php bin/console app:build:sitemap

apache2-foreground