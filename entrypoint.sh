#!/bin/sh

# Clear caches and run migrations
php artisan config:clear
php artisan migrate --force

# Start Reverb in the background!
# The '--host=0.0.0.0' lets Render route public traffic into it.
php artisan reverb:start --host=0.0.0.0 --port=8080 &

# Start the main web server processes
service nginx start
php-fpm