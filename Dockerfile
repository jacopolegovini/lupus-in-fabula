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

# 7. Permessi fondamentali per Laravel
# Render ha bisogno che le cartelle storage e bootstrap siano scrivibili
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 8. Esposizione porta
EXPOSE 8000

# 9. Comando di avvio migliorato
# Usiamo un comando unico che prepara il database e avvia il server
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000
