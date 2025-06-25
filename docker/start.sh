#!/bin/bash

echo "[STARTUP] Fixing permissions..."
mkdir -p /var/www/storage /var/www/bootstrap/cache
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache

echo "[STARTUP] Starting PHP-FPM..."
exec php-fpm
