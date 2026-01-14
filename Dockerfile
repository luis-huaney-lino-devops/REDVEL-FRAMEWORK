# =====================================================
# DOCKERFILE OPTIMIZADO PARA REDVEL FRAMEWORK EN DOKPLOY
# =====================================================

# Stage 1: Composer dependencies
FROM composer:2.7 AS composer-deps
WORKDIR /app
COPY RedBack/composer.json RedBack/composer.lock ./
RUN composer install \
    --no-dev \
    --no-interaction \
    --no-scripts \
    --prefer-dist \
    --optimize-autoloader \
    --ignore-platform-reqs

# Stage 2: Node.js para assets
FROM node:20-alpine AS node-builder
WORKDIR /app
COPY RedBack/package.json ./
RUN npm install
COPY RedBack/vite.config.js ./
COPY RedBack/resources/ ./resources/
COPY RedBack/public/ ./public/
RUN npm run build || true

# Stage 3: Imagen de producción
FROM php:8.3-fpm-alpine AS production

# Instalar dependencias del sistema
RUN apk add --no-cache \
    nginx \
    supervisor \
    curl \
    git \
    zip \
    unzip \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    freetype-dev \
    libzip-dev \
    icu-dev \
    oniguruma-dev \
    libxml2-dev \
    mysql-client \
    redis \
    && rm -rf /var/cache/apk/*

# Instalar extensiones PHP
RUN apk add --no-cache --virtual .build-deps \
    $PHPIZE_DEPS \
    linux-headers \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) \
    pdo \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
    intl \
    calendar \
    opcache \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del .build-deps

# Configurar OPcache
RUN echo 'opcache.enable=1' >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo 'opcache.memory_consumption=256' >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo 'opcache.interned_strings_buffer=16' >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo 'opcache.max_accelerated_files=20000' >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo 'opcache.validate_timestamps=0' >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo 'opcache.save_comments=1' >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo 'opcache.fast_shutdown=1' >> /usr/local/etc/php/conf.d/opcache.ini

# Configurar PHP
RUN echo 'memory_limit=512M' >> /usr/local/etc/php/conf.d/docker-php-memlimit.ini \
    && echo 'upload_max_filesize=100M' >> /usr/local/etc/php/conf.d/docker-php-uploads.ini \
    && echo 'post_max_size=100M' >> /usr/local/etc/php/conf.d/docker-php-uploads.ini \
    && echo 'max_execution_time=300' >> /usr/local/etc/php/conf.d/docker-php-limits.ini \
    && echo 'max_input_time=300' >> /usr/local/etc/php/conf.d/docker-php-limits.ini

# Configurar PHP-FPM pool
RUN sed -i 's/pm.max_children = 5/pm.max_children = 50/g' /usr/local/etc/php-fpm.d/www.conf \
    && sed -i 's/pm.start_servers = 2/pm.start_servers = 10/g' /usr/local/etc/php-fpm.d/www.conf \
    && sed -i 's/pm.min_spare_servers = 1/pm.min_spare_servers = 5/g' /usr/local/etc/php-fpm.d/www.conf \
    && sed -i 's/pm.max_spare_servers = 3/pm.max_spare_servers = 20/g' /usr/local/etc/php-fpm.d/www.conf \
    && sed -i 's/^;listen = .*/listen = 127.0.0.1:9000/' /usr/local/etc/php-fpm.d/www.conf \
    && sed -i 's/^listen = .*/listen = 127.0.0.1:9000/' /usr/local/etc/php-fpm.d/www.conf

# Fix Nginx permissions for www-data
RUN mkdir -p /var/lib/nginx/tmp /var/log/nginx \
    && chown -R www-data:www-data /var/lib/nginx /var/log/nginx

# Instalar Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Crear directorio de trabajo
WORKDIR /var/www/html

# Copiar código fuente desde RedBack
COPY --chown=www-data:www-data RedBack/ .

# Copiar dependencias de composer
COPY --from=composer-deps --chown=www-data:www-data /app/vendor ./vendor

# Copiar assets compilados
COPY --from=node-builder --chown=www-data:www-data /app/public/build ./public/build

# Permisos
RUN chmod -R 755 storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

# Configs
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Directorios de log y cache
RUN mkdir -p /var/log/supervisor \
    && mkdir -p /var/run/nginx \
    && mkdir -p storage/framework/{sessions,views,cache} \
    && mkdir -p storage/logs

EXPOSE 80

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
