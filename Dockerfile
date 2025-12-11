FROM php:8.2-cli

# 1. Instalar utilidades y drivers para la base de datos
RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    git \
    curl \
    gnupg \
    && docker-php-ext-install pdo pdo_pgsql

# 2. Instalar Node.js (necesario para los estilos de tu Hotel)
RUN curl -sL https://deb.nodesource.com/setup_18.x | bash -
RUN apt-get install -y nodejs

# 3. Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Copiar archivos del proyecto
WORKDIR /var/www/html
COPY . .

# 5. Construir los estilos (CSS/JS)
RUN npm install
RUN npm run build

# 6. Instalar dependencias de Laravel
RUN composer install --no-dev --optimize-autoloader

# 7. Configurar puerto y arranque
EXPOSE 10000
CMD bash -c "php artisan migrate --force && php artisan storage:link && php artisan serve --host=0.0.0.0 --port=10000"
