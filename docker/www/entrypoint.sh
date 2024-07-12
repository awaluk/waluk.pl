#!/bin/bash

if [ -n "$CONTENT_REPO_URL" ] && [ ! -d "/var/www/posts" ]; then
  echo "Cloning content repository from: $CONTENT_REPO_URL"
  git clone -b $CONTENT_REPO_BRANCH $CONTENT_REPO_URL /var/www/posts

  if [ $? -ne 0 ]; then
    echo "Error: content cloning failed"
    exit 1
  fi
fi

sleep 3

php bin/console app:load:posts
php bin/console app:build:blog-rss
php bin/console app:build:sitemap

apache2-foreground