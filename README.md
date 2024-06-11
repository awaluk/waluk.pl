# waluk.pl

Page about me with blog

## Stack
- PHP 8
- Symfony 7
- MySQL 8
- Node 20 (Webpack with Encore)
- Docker

## Installation

### Production
1. `composer install --no-dev --optimize-autoloader`
2. `npm ci`
3. `npm run build`
4. Prepare database, execute `docker/mysql/database.sql` to create initial structure
5. Prepare `.env.local` based on `.env`
6. Build image from Dockerfile
7. Run container with image
   - expose port 80
   - mount/copy `.env.local` to `/var/www` in container
   - mount/copy SSH key to `/root/.ssh/` in container
   - set `CONTENT_REPO_URL` and `CONTENT_REPO_BRANCH` environment variables

### Development
1. `docker compose up`
2. `docker compose exec www bash`
3. `composer install`
4. `npm install`
5. `npm run dev` / `npm run watch`

## Available commands
- `php bin/console app:load:posts` - load all posts from md files to database
- `php bin/console app:build:blog-rss` - generate RSS file for blog
- `php bin/console app:build:sitemap` - generate sitemap
