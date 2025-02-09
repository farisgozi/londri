#!/bin/bash

# Function to handle shutdown
shutdown() {
    echo "Received shutdown signal"
    apache2ctl graceful-stop
    exit 0
}

# Trap signals
trap 'shutdown' SIGTERM SIGINT
trap '' SIGWINCH

# Set up environment
export PORT="${PORT:-80}"
export APACHE_RUN_USER=www-data
export APACHE_RUN_GROUP=www-data

# Configure Apache
cp /etc/apache2/ports.conf.template /etc/apache2/ports.conf
sed -i "s/Listen 80/Listen ${PORT}/g" /etc/apache2/ports.conf
sed -i "s/*:80/*:${PORT}/g" /etc/apache2/sites-available/000-default.conf

# Start Apache in foreground
echo "Starting Apache on port ${PORT}"
exec apache2-foreground "$@"