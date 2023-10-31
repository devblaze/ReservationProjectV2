#!/bin/bash

# Run Composer update
echo "Updating Composer dependencies..."
./vendor/bin/sail composer update

# Run NPM update
echo "Updating NPM dependencies..."
./vendor/bin/sail npm update

# Clear caches
echo "Clearing caches..."
./vendor/bin/sail artisan config:clear
./vendor/bin/sail artisan route:clear
./vendor/bin/sail artisan view:clear

# Update the database
echo "Migrating the database..."
./vendor/bin/sail artisan migrate

# Stop sail
echo "Restarting sail..."
./vendor/bin/sail stop

# Start sail
./vendor/bin/sail start -d
echo "Sail is up!"

echo "Update complete."
