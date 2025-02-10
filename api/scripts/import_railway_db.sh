#!/bin/bash

# MySQL connection details from Railway
DB_HOST="junction.proxy.rlwy.net"
DB_USER="root"
DB_PASS="cRnXiGlJHfVnOHMvduUgHnKiiqEfhUCR"
DB_NAME="railway"
DB_PORT="29252"

echo "Attempting to import database..."
echo "Host: $DB_HOST"
echo "Port: $DB_PORT"
echo "Database: $DB_NAME"

# Import the database using mariadb with SSL disabled
mariadb --skip-ssl -h "$DB_HOST" -P "$DB_PORT" -u "$DB_USER" -p"$DB_PASS" "$DB_NAME" < aplikasilaundry.sql

# Check if import was successful
if [ $? -eq 0 ]; then
    echo "Database imported successfully!"
else
    echo "Error importing database"
    exit 1
fi