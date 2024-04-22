# waluk.pl

## Development installation
1. `docker-compose up`
2. `composer install`
3. `npm install && npm run dev`

## Custom commands
- `php bin/console app:load:posts` - load all posts from md files to database
- `php bin/console app:build:blog-rss` - generate RSS file for blog
- `php bin/console app:build:sitemap` - generate sitemap
