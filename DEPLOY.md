# Deployment Guide for LaundryApp on Railway

## Prerequisites
1. GitHub account
2. Railway account
3. Your code pushed to a GitHub repository

## Step 1: Database Setup (Already Done)
- MySQL database is set up on Railway
- Database schema has been imported
- Connection details are configured

## Step 2: Application Configuration (Done)
- Dockerfile created with PHP 8.2 and Apache
- Apache configuration set up
- Environment variables configured
- Database connection settings updated

## Step 3: Deploy via Railway Web Interface

1. Go to Railway Dashboard
   - Visit https://railway.app/dashboard
   - Select your project "londri"

2. Add Web Service
   - Click "New Service"
   - Select "GitHub Repo"
   - Connect your GitHub repository
   - Select the repository with LaundryApp code

3. Environment Variables
   The following variables are already set:
   ```
   DB_HOST=junction.proxy.rlwy.net
   DB_USER=root
   DB_PASS=cRnXiGlJHfVnOHMvduUgHnKiiqEfhUCR
   DB_NAME=railway
   DB_PORT=29252
   ```

4. Deployment Settings
   The following files are configured:
   - `Dockerfile`: PHP 8.2 with Apache setup
   - `000-default.conf`: Apache configuration
   - `railway.toml`: Railway deployment settings

## Step 4: Verify Deployment

1. Check Build Logs
   - Go to your service in Railway dashboard
   - Click on "Deployments" tab
   - Monitor Docker build process
   - Check for any build errors

2. Access Your Application
   - Click on "Settings" tab
   - Look for "Domains" section
   - Your app will be available at the provided domain

## Troubleshooting

1. Database Connection Issues
   - Verify environment variables in Railway dashboard
   - Check if MySQL service is running
   - Test connection using provided credentials

2. Docker Build Issues
   - Check Dockerfile syntax
   - Verify PHP extensions are installed
   - Check Apache configuration
   - Monitor build logs in Railway dashboard

3. Application Errors
   - Check application logs in Railway dashboard
   - Verify file permissions
   - Check PHP configuration
   - Monitor Apache error logs

## Important Notes

- Keep your database credentials secure
- Don't commit .env files to git
- Monitor your application logs
- Regularly backup your database

## Maintenance

1. Updating Application
   - Push changes to GitHub
   - Railway will automatically rebuild Docker image
   - Monitor deployment progress

2. Database Management
   - Use Railway dashboard to manage database
   - Take regular backups
   - Monitor database metrics

3. Monitoring
   - Check Docker container logs
   - Monitor database connections
   - Watch for error notifications
   - Check Apache access and error logs