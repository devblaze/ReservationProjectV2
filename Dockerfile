# Use an official PHP runtime as a base image for production, with the PHP-FPM variant
FROM php:8.1-fpm

# Arguments for UID and GID (useful for development with a system user, can be skipped or customized)
ARG user=www-data
ARG uid=1000

# Install system dependencies, including those needed for MySQL and Node.js
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    curl \
    git \
    nodejs \
    npm \
    supervisor

# Install PHP extensions for Laravel
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd xml

# Clean up to reduce image size
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Set working directory inside the container
WORKDIR /var/www/html

# Create system user and set ownership (optional for some setups)
RUN useradd -G www-data,root -u $uid -d /home/$user $user

# Copy your application code into the container
COPY . /var/www/html

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --no-interaction --optimize-autoloader

# Build frontend assets (only if using frontend frameworks like React/Vue with Laravel Mix)
RUN npm install && npm run prod

# Copy Laravel production environment file
COPY .env.production /var/www/html/.env

# Set the correct permissions
RUN chown -R $user:$user /var/www/html

# Set user context
USER $user

# Expose port 9000 for PHP-FPM
EXPOSE 9000

CMD ["php-fpm"]
