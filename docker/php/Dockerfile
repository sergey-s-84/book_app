# Используем официальный образ PHP 8.1 FPM Alpine
FROM php:8.1-fpm-alpine

# Устанавливаем необходимые расширения PHP
# Установка зависимостей для расширений
RUN apk add --no-cache \
    autoconf \
    build-base \
    libzip-dev \
    libpng-dev \
    jpeg-dev \
    freetype-dev \
    libwebp-dev \
    icu-dev \
    oniguruma-dev \
    git

# Установка расширений PHP
RUN docker-php-ext-install -j$(nproc) pdo pdo_mysql opcache \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install -j$(nproc) intl mbstring zip

# Устанавливаем Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Устанавливаем рабочую директорию
WORKDIR /var/www/html

# Копируем файл php.ini (если нужен кастомный)
# COPY php.ini /usr/local/etc/php/conf.d/40-custom.ini

EXPOSE 9000
CMD ["php-fpm"]
