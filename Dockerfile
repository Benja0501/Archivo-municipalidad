FROM php:8.3-fpm

# Dependencias de sistema
RUN apt-get update && apt-get install -y \
    git unzip zip curl \
    libzip-dev libonig-dev libpng-dev \
    && docker-php-ext-install pdo_mysql zip gd

# Node (para Vite, Breeze, etc.)
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Opcional: permisos
RUN chown -R www-data:www-data /var/www/html
USER www-data
