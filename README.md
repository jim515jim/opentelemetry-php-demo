# Open-telemetry-php-demo

## Version
```shell
PHP version 8.1
LARAVEL version 10.14.1
```

## Installation

install composer vendor
```shell
docker run --rm -e PHP_VERSION=8.1 -v $(pwd):/app composer install
```

copy .env
```shell
cp .env.example .env
```

creat .env key
```shell
docker run --rm -v $(pwd):/app -w /app php:8.1-fpm php artisan key:generate
```
change .env
```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=root
```

use migrate
```
docker compose exec app php artisan migrate
```
