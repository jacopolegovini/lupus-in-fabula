FROM php:8.2-fpm

WORKDIR /var/www/html

# Installazione dipendenze
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git curl nodejs npm sqlite3 libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite zip

# Copia file
COPY . .

# Installazione Composer e dipendenze
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

# Settiamo i permessi per le cartelle dove Laravel deve scrivere
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Creiamo la cartella per il database
RUN mkdir -p /var/www/html/database && chown -R www-data:www-data /var/www/html/database

EXPOSE 8000

# Comando di avvio:
# 1. Crea il file database se non esiste
# 2. Imposta i permessi di scrittura
# 3. Esegue le migrazioni
# 4. Avvia il server
CMD touch /var/www/html/database/database.sqlite && \
    chmod 666 /var/www/html/database/database.sqlite && \
    php artisan migrate --force && \
    php artisan serve --host=0.0.0.0 --port=8000
