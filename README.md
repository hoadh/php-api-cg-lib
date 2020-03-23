# CodeGym Library Backend

## Requirements

* Docker
* Docker-compose

## Deploy

```bash
# Clone this repository
# Change directory to "backend" folder

# Run this command to install requirements package for Laravel:
$ docker run --rm -v $(pwd):/app prooph/composer:7.3 install

# Start building Docker containers
$ docker-compose up -d

# Init environment file
$ cp .env.example .env

# Generate key và optimze command:
$ docker-compose exec app php artisan key:generate
$ docker-compose exec app php artisan jwt:secret
$ docker-compose exec app php artisan storage:link
$ sudo chmod -R 777 storage
```
