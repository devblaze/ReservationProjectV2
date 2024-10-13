# Use official PHP 8.2 FPM image
FROM php:8.2-fpm

# Setup user to match your host's user ID
RUN usermod -u 1000 www-data

# Install system dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    curl \
    unzip \
    git \
    libzip-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    vim \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Node.js (use Node 20.x)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create and set application directory
WORKDIR /var/www/html

# Copy application to container
COPY . /var/www/html

# Ensure proper permissions for www-data user
# RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 777 /var/www/html

# Create .npm directory and set permissions
RUN mkdir -p /var/www/.npm && chown -R www-data:www-data /var/www/.npm

# Switch to www-data user
USER www-data

# Remove existing node_modules
RUN rm -rf node_modules

# Install project dependencies
RUN composer install --no-dev --optimize-autoloader

# Install NPM dependencies and compile assets
RUN npm cache clean --force
RUN npm install
RUN npm run build

# Clear caches and remake config cache
RUN php artisan config:clear
RUN php artisan route:clear
RUN php artisan view:clear
RUN php artisan config:cache

# Refresh the database schema, seed with initial data, and update the search index
# RUN php artisan scout:flush "App\Models\Event"
# RUN php artisan scout:import "App\Models\Event"

# Expose port (9000 for PHP-FPM)
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
