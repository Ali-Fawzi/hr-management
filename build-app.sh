#!/bin/bash
# Make sure this file has executable permissions, run `chmod +x deploy.sh`

# Exit the script if any command fails
set -e

# Maintenance mode (capture any existing maintenance mode status)
php artisan down || true

# Install composer dependencies (production-optimized)
composer install --no-dev --prefer-dist --optimize-autoloader

# Install npm dependencies and build assets
npm ci --production
npm run build

# Run database migrations with force (for production environments)
php artisan migrate --force
# Optional: Seed the database if needed (usually not recommended in production)
# php artisan db:seed --force

# Clear and cache configuration
php artisan config:clear
php artisan config:cache

# Clear and cache routes
php artisan route:clear
php artisan route:cache

# Clear and cache views
php artisan view:clear
php artisan view:cache

# Cache events (Laravel 8.63+)
php artisan event:cache

# Link storage if not already linked
php artisan storage:link

# Optimize the application
php artisan optimize

# Set proper permissions for Laravel directories
chmod -R 775 storage bootstrap/cache
chmod -R 755 public

# Reload PHP-FPM (uncomment if using PHP-FPM)
# sudo service php8.2-fpm reload

# Exit maintenance mode
php artisan up

echo "Deployment completed successfully!"