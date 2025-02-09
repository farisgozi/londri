FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql mysqli

# Enable Apache modules
RUN a2enmod rewrite headers proxy proxy_fcgi

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . /var/www/html/

# Copy Apache configurations
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf
COPY ports.conf /etc/apache2/ports.conf.template

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Configure Apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Configure PHP
RUN echo "memory_limit=512M" > /usr/local/etc/php/conf.d/memory-limit.ini \
    && echo "max_execution_time=300" >> /usr/local/etc/php/conf.d/memory-limit.ini \
    && echo "upload_max_filesize=64M" >> /usr/local/etc/php/conf.d/memory-limit.ini \
    && echo "post_max_size=64M" >> /usr/local/etc/php/conf.d/memory-limit.ini

# Create entrypoint script
RUN echo '#!/bin/bash\n\
export PORT="${PORT:-80}"\n\
export APACHE_RUN_USER=www-data\n\
export APACHE_RUN_GROUP=www-data\n\
cp /etc/apache2/ports.conf.template /etc/apache2/ports.conf\n\
sed -i "s/Listen 80/Listen ${PORT}/g" /etc/apache2/ports.conf\n\
sed -i "s/*:80/*:${PORT}/g" /etc/apache2/sites-available/000-default.conf\n\
exec apache2-foreground' > /usr/local/bin/docker-entrypoint.sh \
    && chmod +x /usr/local/bin/docker-entrypoint.sh

# Expose default port
EXPOSE 80

# Health check
HEALTHCHECK --interval=30s --timeout=10s --start-period=30s --retries=3 \
    CMD curl -f http://localhost:${PORT:-80}/login.php || exit 1

# Start Apache using the entrypoint script
ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]