# ==========================================
# STAGE 1: Builder (Tahap Membangun)
# ==========================================
FROM php:8.3-cli-alpine AS builder

# Instalasi dependensi sistem untuk build (termasuk git, unzip, dev libs)
RUN apk add --no-cache \
    curl \
    git \
    unzip \
    libzip-dev \
    sqlite-dev \
    oniguruma-dev \
    libxml2-dev \
    linux-headers \
    && docker-php-ext-install pdo_sqlite mbstring xml ctype bcmath

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Cache layer: Salin composer
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --no-scripts --no-autoloader --prefer-dist

# Salin kode aplikasi
COPY . .

# Generate autoloader teroptimasi
RUN composer dump-autoload --optimize

# Persiapkan environment dan database SQLite
RUN if [ ! -f .env ]; then cp .env.example .env; fi \
    && php artisan key:generate \
    && mkdir -p database \
    && touch database/database.sqlite \
    && php artisan migrate --force \
    && php artisan config:cache \
    && php artisan route:cache

# ==========================================
# STAGE 2: Runtime (Tahap Menjalankan)
# ==========================================
FROM php:8.3-cli-alpine

# Instalasi ekstensi PHP dengan cara ringan: 
# pakai virtual packages (.build-deps) untuk compile, lalu langsung dihapus.
RUN apk add --no-cache \
    curl \
    sqlite-libs \
    libzip \
    oniguruma \
    libxml2 \
    && apk add --no-cache --virtual .build-deps \
       sqlite-dev \
       oniguruma-dev \
       libxml2-dev \
       libzip-dev \
       linux-headers \
    && docker-php-ext-install pdo_sqlite mbstring xml ctype bcmath \
    && apk del .build-deps

WORKDIR /var/www/html

# Salin HANYA hasil build aplikasi dari stage builder
COPY --from=builder /var/www/html /var/www/html

# Buat dan gunakan user non-root demi keamanan
RUN addgroup -g 1000 laravel \
    && adduser -G laravel -u 1000 -s /bin/sh -D laravel \
    && chown -R laravel:laravel /var/www/html

USER laravel

# Tentukan HEALTHCHECK agar container bisa dimonitor (status healthy)
HEALTHCHECK --interval=30s --timeout=30s --start-period=5s --retries=3 \
  CMD curl -f http://localhost:8000/ || exit 1

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
