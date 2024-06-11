#!/bin/bash

if [ -n "$CONTENT_REPO_URL" ] && [ ! -d "/var/www/posts" ]; then
  echo "Cloning content repository from: $CONTENT_REPO_URL"
  ssh-keyscan github.com >> /root/.ssh/known_hosts
  git clone -b $CONTENT_REPO_BRANCH $CONTENT_REPO_URL /var/www/posts

  if [ $? -ne 0 ]; then
    echo "Error: content cloning failed"
    exit 1
  fi
fi

sleep 3
chown -R www-data:www-data /var/www

sudo -u www-data php bin/console app:load:posts
sudo -u www-data php bin/console app:build:blog-rss
sudo -u www-data php bin/console app:build:sitemap

apache2-foreground