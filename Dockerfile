FROM php:8.2-fpm

WORKDIR /var/www/html

# 1. Installazione dipendenze di sistema
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git curl nodejs npm sqlite3 libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite zip

# 2. Copia dei file del progetto
COPY . .

# 3. Installazione Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# 4. Compilazione Asset con Vite (Fondamentale)
RUN npm install
RUN npm run build

# 5. Settaggio Permessi
# Dobbiamo assicurarci che TUTTA la cartella public e storage sia scrivibile
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public

# 6. Creazione cartella database
RUN mkdir -p /var/www/html/database && chown -R www-data:www-data /var/www/html/database

EXPOSE 8000

# 7. Comando di avvio
CMD touch /var/www/html/database/database.sqlite && \
    chmod 666 /var/www/html/database/database.sqlite && \
    php artisan migrate --force && \
    php artisan serve --host=0.0.0.0 --port=8000
