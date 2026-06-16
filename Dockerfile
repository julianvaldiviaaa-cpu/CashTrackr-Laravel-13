# === ETAPA 1: Compilar estilos y JavaScript ===
FROM node:20-alpine AS frontend-builder
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY . .
RUN npm run build

# === ETAPA 2: Configurar el servidor PHP y Nginx ===
FROM php:8.2-fpm

# Instalar dependencias del sistema esenciales para Laravel y Neon (PostgreSQL)
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nginx \
    libpq-dev

# Instalar extensiones de PHP
RUN docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar el proyecto al servidor
WORKDIR /var/www
COPY . .

# Instalar dependencias de PHP sin entorno de desarrollo
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# TRAER LOS ESTILOS COMPILADOS DESDE LA ETAPA 1
COPY --from=frontend-builder /app/public/build ./public/build

# Configurar permisos para Laravel
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Configurar Nginx
COPY ./nginx.conf /etc/nginx/sites-available/default

RUN ls -la /var/www/public/build/ && cat /var/www/public/build/.vite/manifest.json || echo "MANIFEST NOT FOUND"

CMD php artisan config:cache && \
    php artisan migrate --force && \
    php-fpm -D && \
    sleep 2 && \
    service nginx start && \
    tail -f /var/log/nginx/error.log
