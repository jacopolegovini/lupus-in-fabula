# 1. Base image con PHP e Composer
FROM php:8.2-fpm

# 2. Cartella di lavoro
WORKDIR /var/www/html

# 3. Installo dipendenze di sistema necessarie
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git curl nodejs npm sqlite3 libsqlite3-dev && \
    docker-php-ext-install pdo pdo_sqlite zip

# 4. Copio il progetto dentro il container
COPY . .

# 5. Installo Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 6. Installo le dipendenze PHP e Node
RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

# 7. Creo la cartella per SQLite se non esiste
RUN mkdir -p /var/data && touch /var/data/database.sqlite

# 8. Copio l'.env.example e rinomino come .env
RUN cp .env.example .env

# 9. Genero la chiave app
RUN php artisan key:generate

# 10. Migrate automatico
RUN php artisan migrate --force

# 11. Esposizione porta
EXPOSE 8000

# 12. Comando di avvio
CMD php artisan serve --host=0.0.0.0 --port=8000
