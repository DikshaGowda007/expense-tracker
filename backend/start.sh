#!/bin/bash

echo "Starting Laravel..."

# Cache config
php artisan config:cache
php artisan route:cache

# Start PHP-FPM
service nginx start
php-fpm