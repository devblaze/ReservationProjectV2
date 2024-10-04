# Use an official PHP runtime as a base image for production, with the PHP-FPM variant
FROM php:8.2-fpm

# Arguments for user (customizable)
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

# Clean up the image to reduce size
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Set working directory inside container
WORKDIR /var/www/html

# Create system user and set ownership (optional for some setups)
RUN if ! id "$user" >/dev/null 2>&1; then \
    useradd -G www-data,root -u $uid -d /home/$user $user; \
fi

# Set the correct permissions
RUN chown -R $user:$user /var/www/html

# Copy application code into the container
COPY . /var/www/html

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --no-interaction --optimize-autoloader

# Build frontend assets (only if using frontend frameworks like Vite/Vue)
RUN npm install

# Copy Laravel production environment file
COPY .env.example /var/www/html/.env

# Change user and group (to non-root)
#USER $user

# Expose port 9000 for PHP-FPM
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
