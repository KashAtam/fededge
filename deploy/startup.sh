#!/bin/bash
set -e

echo "Laravel: Starting application setup..."

# Check if .env exists, if not create from .env.example
if [ ! -f .env ]; then
    echo "ENV: Creating .env file from .env.example..."
    cp .env.example .env
    echo -e "ENV: Created!\n\n"
fi

# Check if APP_KEY is set in environment variables (from Kubernetes Secret)
if [ ! -z "${APP_KEY}" ]; then
    echo "APP_KEY: Found in environment variables, updating .env file..."
    ESCAPED_APP_KEY=$(printf '%s\n' "$APP_KEY" | sed -e 's/[\/&]/\\&/g')
    if grep -q "^APP_KEY=" .env; then
        sed -i "s/^APP_KEY=.*/APP_KEY=$ESCAPED_APP_KEY/" .env
    else
        echo "APP_KEY=$APP_KEY" >> .env
    fi
    echo -e "APP_KEY: Updated\n\n"
fi

# Generate application key if not already set in .env
if ! grep -q "^APP_KEY=.\+" .env || grep -q "^APP_KEY=$" .env; then
    echo "APP_KEY: Generating a new application key..."
    php artisan key:generate --force
    echo -e "APP_KEY: Generated\n\n"
fi

# Wait for database to be ready
echo "Database: Waiting to be ready..."

MAX_ATTEMPTS=30
ATTEMPT=0

while [ $ATTEMPT -lt $MAX_ATTEMPTS ]; do
    if php -r "
        try {
            \$pdo = new PDO('mysql:host=' . getenv('DB_HOST') . ';port=' . getenv('DB_PORT') . ';dbname=' . getenv('DB_DATABASE'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'));
            exit(0);
        } catch (PDOException \$e) {
            exit(1);
        }
    " >/dev/null 2>&1; then
        echo -e "Database: Ready!\n\n"
        break
    fi

    echo -e "Database: Not ready yet, attempt $((ATTEMPT + 1))/$MAX_ATTEMPTS...\n\n"
    sleep 2
    ATTEMPT=$((ATTEMPT + 1))
done

if [ $ATTEMPT -eq $MAX_ATTEMPTS ]; then
    echo "WARNING: Database connection failed after $MAX_ATTEMPTS attempts"
    echo -e "Continuing setup but migrations may fail...\n\n"
fi

################################
# Migrations
################################
if [ "$APP_ENV" != "testing" ]; then
    echo "Migrations"
    php artisan migrate --force
    echo -e "Migrations: Completed!\n\n"

    if [ "$APP_ENV" != "production" ] || [ "$RUN_SEEDERS" = "true" ]; then
        echo "Seeders"
        php artisan db:seed --force
        echo -e "Seeders: Completed!\n\n"
    fi
fi

################################
# Permissions & Cache
################################
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

if [ "$APP_ENV" != "testing" ]; then
    echo "Cache: Clearing all cached data"
    php artisan optimize:clear
    echo ""
fi

################################
# Storage
################################
echo "Storage: Create link"
mkdir -p storage/app/public
php artisan storage:link --force
echo ""

################################
# Production optimisation
################################
if [ "$APP_ENV" = "production" ]; then
    echo "Optimizing for production..."
    php artisan optimize
    echo ""
fi

echo -e "Laravel: Setup completed successfully!\n\n"

exec "$@"
