# Deployment Guide for LaundryApp on Railway

## Prerequisites
1. GitHub account
2. Railway account
3. Your code pushed to a GitHub repository

## Step 1: Database Setup (Already Done)
- MySQL database is set up on Railway
- Database schema has been imported
- Connection details are configured

## Step 2: Deploy via Railway Web Interface

1. Go to Railway Dashboard
   - Visit https://railway.app/dashboard
   - Select your project "londri"

2. Add Web Service
   - Click "New Service"
   - Select "GitHub Repo"
   - Connect your GitHub repository
   - Select the repository with LaundryApp code

3. Configure Environment Variables
   The following variables are already set:
   ```
   DB_HOST=junction.proxy.rlwy.net
   DB_USER=root
   DB_PASS=cRnXiGlJHfVnOHMvduUgHnKiiqEfhUCR
   DB_NAME=railway
   DB_PORT=29252
   ```

4. Deploy Settings
   The following files are already configured:
   - `Procfile`: Specifies how to run the PHP server
   - `railway.toml`: Contains deployment configuration
   - `composer.json`: Defines PHP dependencies

## Step 3: Verify Deployment

1. Check Build Logs
   - Go to your service in Railway dashboard
   - Click on "Deployments" tab
   - Check build and deployment logs

2. Access Your Application
   - Click on "Settings" tab
   - Look for "Domains" section
   - Your app will be available at the provided domain

## Troubleshooting

1. Database Connection Issues
   - Verify environment variables in Railway dashboard
   - Check if MySQL service is running
   - Test connection using provided credentials

2. Application Errors
   - Check deployment logs in Railway dashboard
   - Verify PHP version compatibility
   - Check file permissions

3. Domain Issues
   - Ensure domain is generated in Railway
   - Wait a few minutes for DNS propagation
   - Check if SSL certificate is provisioned

## Important Notes

- Keep your database credentials secure
- Don't commit .env files to git
- Monitor your application logs
- Regularly backup your database

## Maintenance

1. Updating Application
   - Push changes to GitHub
   - Railway will automatically redeploy

2. Database Management
   - Use Railway dashboard to manage database
   - Take regular backups
   - Monitor database metrics

3. Monitoring
   - Check application logs in Railway dashboard
   - Monitor database connections
   - Watch for error notifications