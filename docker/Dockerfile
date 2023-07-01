FROM php:8.2-fpm

# 設定工作目錄
WORKDIR /var/www/html

# 安裝所需的系統套件和 PHP 擴充功能
RUN apt-get update && apt-get install -y \
    unzip \
    libzip-dev \
    git \
    && docker-php-ext-install mysqli pdo pdo_mysql zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 設定工作目錄
WORKDIR /var/www/html

# 複製 Laravel 專案到工作目錄
COPY . /var/www/html

# 生成應用程式金鑰
RUN php artisan key:generate

# 設定伺服器執行使用者權限
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

EXPOSE 8000
CMD ["php", "artisan", "serve", "--host", "0.0.0.0", "--port", "8000"]
