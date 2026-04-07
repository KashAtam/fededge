# Fededge - Complete Setup & Deployment Guide

## Quick Start (5 Minutes)

For developers who want to get up and running immediately:

```bash
# 1. Clone and enter directory
git clone <repository-url>
cd fededge

# 2. Install dependencies
composer install
npm install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Create database
mysql -u root -p -e "CREATE DATABASE fededge;"

# 5. Run migrations and seed
php artisan migrate:fresh --seed
php artisan storage:link
npm run build

# 6. Start server
php artisan serve
```

**Access the application at**: http://localhost:8000

**Test Accounts**:
- Admin: `admin@fededge.com` / `password`
- Other accounts generated automatically

---

## Detailed Installation Guide

### Prerequisites

Before starting, ensure you have:

1. **PHP 8.2+** installed
   ```bash
   php --version
   ```

2. **Composer** installed
   ```bash
   composer --version
   ```

3. **MySQL/MariaDB** running
   ```bash
   mysql --version
   ```

4. **Node.js & npm** installed
   ```bash
   node --version
   npm --version
   ```

### Step-by-Step Installation

#### 1. Clone Repository

```bash
git clone https://github.com/yourusername/fededge.git
cd fededge
```

#### 2. Install PHP Dependencies

```bash
composer install --prefer-dist
```

If you get permission errors:
```bash
sudo composer install
```

#### 3. Install Node Dependencies

```bash
npm install
# or
pnpm install
```

#### 4. Create Environment File

```bash
cp .env.example .env
```

Edit `.env` and update:

```env
APP_NAME=Fededge
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fededge
DB_USERNAME=root
DB_PASSWORD=your_password

# Mail (optional, for notifications)
MAIL_MAILER=log
MAIL_HOST=localhost
```

#### 5. Generate Application Key

```bash
php artisan key:generate
```

This creates a unique encryption key for your application.

#### 6. Create Database

**Option A: Using MySQL CLI**
```bash
mysql -u root -p
mysql> CREATE DATABASE fededge;
mysql> EXIT;
```

**Option B: Using phpMyAdmin**
1. Open phpMyAdmin
2. Click "New"
3. Enter database name: `fededge`
4. Click "Create"

#### 7. Run Database Migrations

```bash
php artisan migrate
```

This creates all necessary tables in your database.

#### 8. Seed Test Data

```bash
php artisan db:seed
```

This populates the database with test data including:
- 1 admin user
- 3 road officers
- 10 vehicle owners
- 20+ vehicles
- 60+ documents with various statuses

#### 9. Create Storage Link

```bash
php artisan storage:link
```

This creates a symbolic link for file uploads. If you get an error:

```bash
php artisan storage:link --force
```

#### 10. Build Frontend Assets

```bash
npm run build
```

For development with hot reload:
```bash
npm run dev
```

#### 11. Start Development Server

```bash
php artisan serve
```

The application is now available at **http://localhost:8000**

---

## Configuration Guide

### Database Configuration

In `.env`, update database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fededge
DB_USERNAME=root
DB_PASSWORD=your_password
```

For remote databases:
```env
DB_HOST=your.remote.host
DB_PORT=3306
```

For PostgreSQL:
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=fededge
DB_USERNAME=postgres
DB_PASSWORD=password
```

### File Storage Configuration

**Local Storage** (default):
```env
FILESYSTEM_DISK=local
```

**AWS S3 Storage**:
```env
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=your_key
AWS_SECRET_ACCESS_KEY=your_secret
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your_bucket_name
AWS_URL=https://your_bucket.s3.amazonaws.com
```

### Email Configuration

For email notifications, update `.env`:

```env
# Gmail
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls

# Mailtrap (for testing)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_inbox_id
MAIL_PASSWORD=your_mailtrap_password
```

### Redis Configuration (Optional)

For better performance with caching:

```env
CACHE_DRIVER=redis
QUEUE_CONNECTION=redis

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

---

## User Management

### Creating Admin User

```bash
php artisan tinker
```

In the Tinker shell:
```php
$user = new App\Models\User();
$user->name = 'Admin Name';
$user->email = 'admin@example.com';
$user->password = bcrypt('password123');
$user->role = 'admin';
$user->save();
exit
```

Or via database:
```sql
INSERT INTO users (name, email, password, role, created_at, updated_at)
VALUES ('Admin User', 'admin@fededge.com', '[bcrypt_hash]', 'admin', NOW(), NOW());
```

### Resetting User Password

```bash
php artisan tinker
```

```php
$user = App\Models\User::where('email', 'user@example.com')->first();
$user->password = bcrypt('newpassword');
$user->save();
exit
```

---

## Testing the System

### Test Admin Dashboard

1. Visit http://localhost:8000
2. Login with `admin@fededge.com` / `password`
3. You should see the admin dashboard with statistics and charts

### Test Vehicle Owner Features

1. Login with any of the seeded vehicle owner accounts
2. Click "My Vehicles" to see assigned vehicles
3. Click on a vehicle to see documents
4. Try uploading a new document

### Test Road Officer Features

1. Login with a road officer account
2. Go to "Vehicle Search" section
3. Search by plate number or VIN
4. View vehicle compliance status

### Test Admin Document Review

1. Login as admin
2. Go to "Documents" section
3. Click on pending documents
4. Approve or reject documents

---

## Troubleshooting

### Common Issues & Solutions

#### 1. "PHP Parse Error: syntax error"

**Problem**: PHP version is too old

**Solution**:
```bash
php --version  # Check version
# Update to PHP 8.2+
```

#### 2. "SQLSTATE[HY000]: General error: 1030 Got an error reading communication packets"

**Problem**: MySQL connection issue

**Solution**:
```bash
# Verify MySQL is running
sudo service mysql status

# Restart MySQL
sudo service mysql restart

# Check .env database credentials
# Test connection: mysql -u root -p -h 127.0.0.1
```

#### 3. "Class not found" Error

**Problem**: Autoloader not generated

**Solution**:
```bash
composer dump-autoload
php artisan cache:clear
```

#### 4. "File permissions denied"

**Problem**: Storage directory not writable

**Solution**:
```bash
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
chown -R www-data:www-data storage/
```

#### 5. "CSRF token mismatch"

**Problem**: Session or cache issue

**Solution**:
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

#### 6. "Assets not loading (404 errors)"

**Problem**: Assets not compiled

**Solution**:
```bash
npm run build
php artisan optimize:clear
```

#### 7. "Storage link already exists"

**Problem**: Trying to create link that exists

**Solution**:
```bash
php artisan storage:link --force
```

#### 8. "Database doesn't exist"

**Problem**: Database not created

**Solution**:
```bash
mysql -u root -p
CREATE DATABASE fededge;
EXIT;
php artisan migrate --fresh --seed
```

---

## Performance Optimization

### Enable Caching

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

To clear caches:
```bash
php artisan optimize:clear
```

### Database Optimization

Run these queries periodically:

```sql
ANALYZE TABLE users;
ANALYZE TABLE vehicles;
ANALYZE TABLE documents;
ANALYZE TABLE notifications;
```

### Queue Processing (Optional)

For background jobs:

```bash
php artisan queue:work
```

In production:
```bash
php artisan queue:work --daemon --tries=3 --timeout=90
```

---

## Production Deployment

### Pre-deployment Checklist

- [ ] Update `.env.production`
- [ ] Set `APP_DEBUG=false`
- [ ] Set `APP_ENV=production`
- [ ] Generate new `APP_KEY`
- [ ] Configure real database
- [ ] Setup email service
- [ ] Configure file storage (S3 recommended)
- [ ] Setup SSL/HTTPS
- [ ] Enable HTTPS redirect
- [ ] Setup database backups
- [ ] Configure monitoring
- [ ] Setup rate limiting
- [ ] Run migrations on production

### Deployment Steps

#### 1. Clone Repository
```bash
git clone <repository> /var/www/fededge
cd /var/www/fededge
```

#### 2. Install Dependencies
```bash
composer install --no-dev --optimize-autoloader
npm install
npm run build
```

#### 3. Configure Environment
```bash
cp .env.production .env
php artisan key:generate
```

#### 4. Database Setup
```bash
php artisan migrate --force
# Don't seed in production unless necessary
```

#### 5. Set Permissions
```bash
chown -R www-data:www-data /var/www/fededge
chmod -R 755 /var/www/fededge
chmod -R 775 /var/www/fededge/storage
chmod -R 775 /var/www/fededge/bootstrap/cache
```

#### 6. Configure Web Server

**Nginx Configuration**:
```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /var/www/fededge/public;

    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

#### 7. Setup SSL/HTTPS

Using Let's Encrypt:
```bash
sudo apt install certbot python3-certbot-nginx
sudo certbot certonly --nginx -d yourdomain.com
```

#### 8. Setup Process Manager (Supervisor)

```ini
[program:fededge-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/fededge/artisan queue:work --tries=3
autostart=true
autorestart=true
numprocs=4
redirect_stderr=true
stdout_logfile=/var/log/fededge-worker.log
```

---

## Docker Deployment

### Using Docker

**Dockerfile** (included):
```bash
docker build -t fededge:latest .
docker run -p 8000:8000 fededge:latest
```

**Docker Compose**:
```bash
docker-compose up -d
docker-compose exec app php artisan migrate:fresh --seed
```

---

## Monitoring & Maintenance

### Regular Maintenance Tasks

**Daily**:
- Monitor error logs: `tail -f storage/logs/laravel.log`
- Check queue status: `php artisan queue:failed`

**Weekly**:
- Backup database
- Review access logs
- Check disk space

**Monthly**:
- Update dependencies: `composer update`, `npm update`
- Review user permissions
- Analyze database performance
- Check SSL certificate expiry

### Logs

View application logs:
```bash
tail -f storage/logs/laravel.log
```

Tail with filtering:
```bash
tail -f storage/logs/laravel.log | grep -i error
```

---

## Additional Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Bootstrap Documentation](https://getbootstrap.com/docs)
- [Chart.js Documentation](https://www.chartjs.org/docs)
- [MySQL Documentation](https://dev.mysql.com/doc/)

---

## Support & Contact

For issues or questions:

1. Check the README.md for general information
2. Review Laravel documentation
3. Check error logs: `storage/logs/laravel.log`
4. Create GitHub issue with detailed error

---

## Changelog

**v1.0.0** - Initial Release
- Complete vehicle management system
- Document upload and approval workflow
- Admin dashboard with analytics
- Road officer verification system
- Vehicle owner portal
- Responsive design with dark mode

---

**Last Updated**: April 2026
**Maintained By**: Fededge Team
