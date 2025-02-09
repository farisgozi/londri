FROM php:8.2-apache

# Install PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable Apache modules
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Configure PHP
RUN echo "memory_limit=512M" > /usr/local/etc/php/conf.d/memory-limit.ini

# Configure Apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Copy Apache configs
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf
COPY ports.conf /etc/apache2/ports.conf.template

# Create entrypoint script
RUN echo '#!/bin/bash\n\
export PORT="${PORT:-80}"\n\
envsubst "\${PORT}" < /etc/apache2/ports.conf.template > /etc/apache2/ports.conf\n\
envsubst "\${PORT}" < /etc/apache2/sites-available/000-default.conf > /etc/apache2/sites-available/000-default.conf.tmp\n\
mv /etc/apache2/sites-available/000-default.conf.tmp /etc/apache2/sites-available/000-default.conf\n\
exec apache2-foreground "$@"' > /usr/local/bin/docker-apache-entrypoint \
    && chmod +x /usr/local/bin/docker-apache-entrypoint

# Install envsubst
RUN apt-get update && apt-get install -y gettext-base && rm -rf /var/lib/apt/lists/*

# Expose port
EXPOSE 80

# Use custom entrypoint
ENTRYPOINT ["/usr/local/bin/docker-apache-entrypoint"]
