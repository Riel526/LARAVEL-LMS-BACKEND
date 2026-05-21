FROM php:8.3-fpm

# Install system dependencies and Nginx
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip \
    unzip \
    nginx

# Clear build system cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install required PHP extensions for Laravel and PostgreSQL
RUN docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd

# Grab the official, modern Composer engine binary
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establish production workspace
WORKDIR /var/www

# Copy codebase contents directly into the container
COPY . /var/www

RUN rm -f /var/www/.env

# Run composer installation for production (skips local dev dependencies)
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Apply our custom server routing layout configuration
COPY ./nginx.conf /etc/nginx/sites-available/default

# Adjust directory permissions so Laravel can write logs, cache, and sessions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Expose HTTP web server traffic interface port
EXPOSE 80

# Spin up Nginx and the PHP process processor side-by-side
CMD php artisan config:clear && php artisan migrate --force && service nginx start && php-fpm