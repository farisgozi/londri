# Deployment Guide for Laundry Application on Plesk

## Prerequisites

1. Plesk server with:
   - PHP 8.0 or higher (required by application)
   - MySQL/MariaDB 10.4 or higher
   - Apache web server
   - mod_rewrite enabled

2. Required PHP Extensions (specified in composer.json):
   - mysqli
   - json
   - session
   - mbstring

3. Composer (for dependency management)

## Database Setup

1. Create a new database in Plesk:
   - Database name: `aplikasilaundry` (or your preferred name)
   - Character set: `utf8mb4`
   - Collation: `utf8mb4_general_ci`

2. Create a database user and grant permissions to the database

3. Import the database:
   - Use phpMyAdmin or MySQL command line
   - Import file: `aplikasilaundry.sql`

## Application Setup

1. Prepare the application:
   - Install Composer dependencies:
     ```bash
     composer install --no-dev --optimize-autoloader
     ```

2. Upload application files to Plesk:
   - Use Plesk File Manager or FTP to upload all files to the document root
   - Alternatively, use Git deployment if your code is in a repository
   - Ensure proper file permissions:
     ```bash
     find . -type f -exec chmod 644 {} \;
     find . -type d -exec chmod 755 {} \;
     ```

3. Configure Plesk:
   - Go to Plesk Control Panel > Domains > your domain
   - Enable PHP 8.0 or higher
   - Verify Apache and PHP handlers are properly configured
   - Enable the required PHP extensions in PHP Settings

2. Configure database connection:
   - Edit `config/database.php`
   - Update the following values:
     ```php
     $host = 'localhost';  // Usually localhost
     $user = 'your_db_user';
     $pass = 'your_db_password';
     $db   = 'your_db_name';
     $port = '3306';      // Default MySQL port
     ```

3. Configure Apache:
   - Ensure .htaccess is allowed (AllowOverride All)
   - The existing .htaccess file should work as-is

## Post-Installation

1. Default admin credentials:
   - Username: admin
   - Password: (contact system administrator)
   - Role: admin

2. SSL Configuration:
   - Go to Plesk Control Panel > Domains > your domain > SSL/TLS Certificates
   - Install Let's Encrypt certificate or upload your own SSL certificate
   - Enable 'Permanent SEO-safe 301 redirect from HTTP to HTTPS'

3. Security considerations:
   - Change default admin password immediately
   - Set proper file permissions as mentioned above
   - Enable Plesk's Web Application Firewall
   - Configure automated backups in Plesk:
     * Go to Plesk Control Panel > Domains > your domain > Backup Manager
     * Schedule regular backups of both files and database
     * Store backups in a secure, external location

4. Production Environment:
   - Set PHP to production mode (disable error reporting)
   - Enable PHP OPcache for better performance
   - Configure PHP-FPM for better resource management
   - Set up monitoring and alerts in Plesk

5. Domain Configuration:
   - Configure domain DNS settings in Plesk
   - Set up proper A records and CNAME records
   - Configure email services if needed

## Requirements

1. PHP Extensions:
   - mysqli
   - json
   - session
   - mbstring

2. Server Requirements:
   - Minimum 1GB RAM
   - 10GB storage space
   - Dedicated IP recommended

## Troubleshooting

1. Database connection issues:
   - Verify database credentials
   - Check if database server is running
   - Confirm database user has proper permissions

2. File permission issues:
   - Ensure web server user has read access to all files
   - Ensure web server user has write access to upload directories

3. 500 Internal Server Error:
   - Check PHP error logs
   - Verify .htaccess configuration
   - Confirm all required PHP extensions are enabled

## Support

For technical support or questions about deployment, please contact the development team.

9R41*vug6
gozi

xhkyipxhu
tXroOEef58svg8~@