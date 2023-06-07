# 使用 PHP 官方映像作為基礎
FROM php:8.2-apache

# 安裝所需的擴展或依賴項
RUN apt-get update && \
    apt-get install -y wget && \
    wget -O /usr/local/bin/install-php-extensions https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions \
    && chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions opentelemetry

# 暴露容器的 HTTP 端口
EXPOSE 80