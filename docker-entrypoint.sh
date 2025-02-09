#!/bin/bash
set -e

# Function to stop Apache gracefully
stop_apache() {
    echo "Stopping Apache..."
    apache2ctl graceful-stop
    exit 0
}

# Trap SIGTERM and SIGINT
trap stop_apache SIGTERM SIGINT

# Set default port
PORT="${PORT:-80}"

# Configure Apache
echo "Configuring Apache for port $PORT..."
echo "Listen $PORT" > /etc/apache2/ports.conf
sed -i "s/\${PORT}/$PORT/g" /etc/apache2/sites-available/000-default.conf

# Start Apache in background
echo "Starting Apache..."
apache2-foreground &

# Store Apache PID
APACHE_PID=$!

# Wait for Apache
echo "Apache started with PID $APACHE_PID"
wait $APACHE_PID