# 1. Base image
FROM php:8.2-fpm

# 2. Cartella di lavoro
WORKDIR /var/www/html

# 3. Installo dipendenze di sistema
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git curl nodejs npm sqlite3 libsqlite3-dev && \
    docker-php-ext-install pdo pdo_sqlite zip

# 4. Copio il progetto
COPY . .

# 5. Installo Composer (Metodo più pulito)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 6. Installo dipendenze PHP e Node
RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

# 7. Assicuriamoci che la cartella database esista e abbia i permessi
RUN mkdir -p /var/www/html/database && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database

# 8. Esposizione porta
EXPOSE 8000

# 9. Comando di avvio "intelligente"
# Questo comando crea il file sqlite se manca, dà i permessi e poi avvia Laravel
CMD touch /var/www/html/database/database.sqlite && \
    chmod 666 /var/www/html/database/database.sqlite && \
    php artisan migrate --force && \
    php artisan serve --host=0.0.0.0 --port=8000
