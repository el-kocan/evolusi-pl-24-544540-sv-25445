# 1. Base image resmi PHP 8.3 CLI berbasis Alpine Linux (ringan dan aman)
FROM php:8.3-cli-alpine

# 2. Pasang pustaka sistem dan ekstensi PHP yang dibutuhkan Laravel
RUN apk add --no-cache \
    curl \
    git \
    unzip \
    libzip-dev \
    sqlite-dev \
    sqlite \
    oniguruma-dev \
    libxml2-dev \
    linux-headers \
    && docker-php-ext-install \
    pdo_sqlite \
    mbstring \
    xml \
    ctype \
    bcmath

# 3. Salin Composer biner dari image resmi Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 4. Tentukan working directory aplikasi di dalam container
WORKDIR /var/www/html

# ==============================================================================
# STRATEGI DOCKER LAYER CACHING:
# Salin composer.json dan composer.lock TERLEBIH DAHULU sebelum kode aplikasi.
# Hal ini membuat layer instalasi dependensi (RUN composer install) di-cache.
# Jika kode aplikasi diubah tanpa mengubah dependensi, langkah ini tidak akan
# diunduh/dijalankan ulang sehingga proses build ketiga jauh lebih cepat.
# ==============================================================================
COPY composer.json composer.lock ./

# Pasang dependensi tanpa dev package dan tanpa script autoloader
RUN composer install --no-dev --no-interaction --no-scripts --no-autoloader --prefer-dist

# 5. Salin seluruh kode aplikasi ke dalam container
COPY . .

# 6. Selesaikan pembuatan autoloader yang teroptimasi
RUN composer dump-autoload --optimize

# 7. Konfigurasi environment, application key, database SQLite, dan migrasi tabel
RUN if [ ! -f .env ]; then cp .env.example .env; fi \
    && php artisan key:generate \
    && touch database/database.sqlite \
    && php artisan migrate --force \
    && php artisan config:cache \
    && php artisan route:cache \
    && chown -R www-data:www-data storage bootstrap/cache database

# 8. Ekspos port 8000
EXPOSE 8000

# 9. Jalankan server Laravel bawaan yang mendengarkan seluruh antarmuka jaringan (0.0.0.0)
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
