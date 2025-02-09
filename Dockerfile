FROM httpd:2.4-alpine

# Install PHP and required extensions
RUN apk update && apk add \
    php82 \
    php82-apache2 \
    php82-mysqli \
    php82-pdo \
    php82-pdo_mysql \
    php82-json \
    php82-session \
    && ln -s /usr/bin/php82 /usr/bin/php

# Copy Apache configuration
COPY 000-default.conf /usr/local/apache2/conf/httpd.conf

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . /var/www/html/

# Set permissions
RUN chown -R apache:apache /var/www/html \
    && chmod -R 755 /var/www/html

# Configure PHP
RUN mkdir -p /etc/php82/conf.d \
    && echo "memory_limit=512M" > /etc/php82/conf.d/memory-limit.ini

# Copy and setup start script
COPY start.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/start.sh

# Expose port
EXPOSE 80

# Use our start script
CMD ["/usr/local/bin/start.sh"]
