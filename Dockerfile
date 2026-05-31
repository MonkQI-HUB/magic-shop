FROM dunglas/frankenphp:php8.2-bookworm

# Install system dependencies for intl extension and composer
RUN apt-get update && apt-get install -y \
    libicu-dev \
    git \
    unzip \
    zip \
    && docker-php-ext-install intl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy composer files first for better caching
COPY composer.json composer.lock ./

# Install dependencies
RUN composer install --optimize-autoloader --no-scripts --no-interaction --no-dev

# Copy application code
COPY . .

# Expose the port Railway provides
EXPOSE ${PORT:-80}

# Start FrankenPHP with Caddy
CMD ["frankenphp", "run", "--config", "/etc/caddy/Caddyfile"]
