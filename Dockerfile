FROM php:8.2-fpm

# Instalar dependencias del sistema esenciales (incluyendo libpq para PostgreSQL)
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

# Instalar extensiones de PHP optimizadas para Laravel, MySQL y Neon (PostgreSQL)
RUN docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar el proyecto
WORKDIR /var/www
COPY . .

# Instalar dependencias de Laravel ignorando restricciones de plataforma de desarrollo
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# Configurar permisos para Laravel
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Configurar Nginx
COPY ./nginx.conf /etc/nginx/sites-available/default

CMD php artisan migrate --force && service nginx start && php-fpm
