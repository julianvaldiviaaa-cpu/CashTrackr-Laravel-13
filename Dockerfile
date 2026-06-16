FROM php:8.2-fpm

# Instalar dependencias del sistema esenciales, incluyendo libpq para PostgreSQL y Node.js con NPM
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nginx \
    libpq-dev \
    gnupg

# Instalar Node.js (Versión 20) y NPM para compilar los estilos
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | build-dev=1 bash - \
    && apt-get install -y nodesource-repo \
    && apt-get install -y nodejs

# Instalar extensiones de PHP optimizadas para Laravel y Neon (PostgreSQL)
RUN docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar el proyecto al contenedor
WORKDIR /var/www
COPY . .

# Instalar dependencias de PHP
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# Instalar dependencias de JavaScript y compilar estilos (Vite / React / Tailwind)
RUN npm install
RUN npm run build

# Configurar permisos para Laravel
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Configurar Nginx
COPY ./nginx.conf /etc/nginx/sites-available/default

# Correr migraciones automáticamente y encender el servidor
CMD php artisan migrate --force && service nginx start && php-fpm
