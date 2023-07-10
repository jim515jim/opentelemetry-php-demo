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

{job="fluentbit"} | json | line_format "{{.log}}" | regexp "(?P<DockerLevel>\\w+)  (?P<AppLog>.*)\\." 