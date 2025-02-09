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
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf \
    && echo "Listen 80" > /etc/apache2/ports.conf

# Copy Apache config
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

# Create simple entrypoint
RUN echo '#!/bin/sh\n\
sed -i "s/80/$PORT/g" /etc/apache2/ports.conf\n\
apache2-foreground' > /usr/local/bin/entrypoint.sh \
    && chmod +x /usr/local/bin/entrypoint.sh

# Expose port
EXPOSE 80

# Start Apache
CMD ["/usr/local/bin/entrypoint.sh"]
