#!/bin/bash

# Get MySQL connection details from Railway
MYSQL_HOST=$(railway variables get MYSQLHOST)
MYSQL_USER=$(railway variables get MYSQLUSER)
MYSQL_PASS=$(railway variables get MYSQLPASSWORD)
MYSQL_DB=$(railway variables get MYSQLDATABASE)

# Import the database
mysql -h "$MYSQL_HOST" -u "$MYSQL_USER" -p"$MYSQL_PASS" "$MYSQL_DB" < aplikasilaundry.sql

# Check if import was successful
if [ $? -eq 0 ]; then
    echo "Database imported successfully!"
else
    echo "Error importing database"
    exit 1
fi