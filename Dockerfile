FROM dunglas/frankenphp:1-php8.4

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libicu-dev \
    libzip-dev \
    default-mysql-client \
    zip \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql exif pcntl bcmath gd intl zip
RUN pecl install redis && docker-php-ext-enable redis

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy application code
COPY . .

# Create required directories and set permissions FIRST
RUN mkdir -p storage/logs \
    && mkdir -p storage/framework/cache \
    && mkdir -p storage/framework/sessions \
    && mkdir -p storage/framework/views \
    && mkdir -p storage/app/public \
    && mkdir -p bootstrap/cache \
    && chown -R www-data:www-data /app \
    && chmod -R 775 storage \
    && chmod -R 775 bootstrap/cache

# Install dependencies (after creating directories)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Create Caddyfile for FrankenPHP
RUN echo ":8000 {\n\
    root * /app/public\n\
    encode zstd gzip\n\
    php_server\n\
}" > /etc/caddy/Caddyfile

EXPOSE 8000

# Start FrankenPHP
CMD ["frankenphp", "run", "--config", "/etc/caddy/Caddyfile"]
