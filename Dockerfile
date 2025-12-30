# 1. Base image con PHP e estensioni necessarie
FROM php:8.2-fpm

# 2. Cartella di lavoro
WORKDIR /var/www/html

# 3. Installazione dipendenze di sistema e SQLite
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git curl nodejs npm sqlite3 libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite zip

# 4. Copia del codice nel container
COPY . .

# 5. Installazione Composer (usando l'immagine ufficiale come fonte)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# 6. Preparazione cartelle e permessi (fondamentale per Vite e Laravel)
# Creiamo le cartelle prima della build per evitare errori di permessi
RUN mkdir -p storage bootstrap/cache public/build database \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache public

# 7. Compilazione Asset con Vite
# Avendo pulito il vite.config.js, questo comando genererà il manifest correttamente
RUN npm install && npm run build

# 8. Esposizione della porta (Render usa la 8000 o quella definita nel pannello)
EXPOSE 8000

# 9. Comando di avvio (CMD)
# Questo script viene eseguito ogni volta che il container parte:
# - Crea il file sqlite se non esiste
# - Sistema i permessi del file database
# - Esegue le migrazioni
# - Avvia il server
CMD touch /var/www/html/database/database.sqlite && \
    chmod 666 /var/www/html/database/database.sqlite && \
    php artisan migrate --force && \
    php artisan serve --host=0.0.0.0 --port=8000
