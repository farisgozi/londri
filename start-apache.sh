#!/bin/bash

# Set default port if not set
: "${PORT:=80}"

# Replace port in Apache configs
sed -i "s/\${PORT:-80}/$PORT/g" /etc/apache2/sites-available/000-default.conf
echo "Listen $PORT" > /etc/apache2/ports.conf

# Start Apache through supervisord
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf