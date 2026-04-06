#!/bin/bash

# Fededge - Installation Script
# This script automates the installation process for the Fededge application

echo "=========================================="
echo "  Fededge Installation Script"
echo "=========================================="
echo ""

# Colors for output
GREEN='\033[0;32m'
BLUE='\033[0;34m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Function to print colored messages
print_step() {
    echo -e "${BLUE}▶ $1${NC}"
}

print_success() {
    echo -e "${GREEN}✓ $1${NC}"
}

print_warning() {
    echo -e "${YELLOW}⚠ $1${NC}"
}

# Check if running from correct directory
if [ ! -f "composer.json" ]; then
    print_warning "Please run this script from the project root directory"
    exit 1
fi

# Check dependencies
print_step "Checking dependencies..."

if ! command -v php &> /dev/null; then
    print_warning "PHP is not installed. Please install PHP 8.2 or higher."
    exit 1
fi

if ! command -v composer &> /dev/null; then
    print_warning "Composer is not installed. Please install Composer."
    exit 1
fi

if ! command -v node &> /dev/null; then
    print_warning "Node.js is not installed. Please install Node.js."
    exit 1
fi

print_success "Dependencies found"
echo ""

# Install PHP dependencies
print_step "Installing PHP dependencies..."
composer install --prefer-dist
print_success "PHP dependencies installed"
echo ""

# Install Node dependencies
print_step "Installing Node dependencies..."
npm install
print_success "Node dependencies installed"
echo ""

# Create environment file
print_step "Creating environment file..."
if [ ! -f ".env" ]; then
    cp .env.example .env
    print_success "Environment file created"
else
    print_warning "Environment file already exists"
fi
echo ""

# Generate application key
print_step "Generating application key..."
php artisan key:generate
print_success "Application key generated"
echo ""

# Database setup
print_step "Database setup..."
read -p "Database name (default: fededge): " db_name
db_name=${db_name:-fededge}

read -p "Database user (default: root): " db_user
db_user=${db_user:-root}

read -s -p "Database password: " db_pass
echo ""

# Update .env file
sed -i "s/DB_DATABASE=.*/DB_DATABASE=$db_name/" .env
sed -i "s/DB_USERNAME=.*/DB_USERNAME=$db_user/" .env
sed -i "s/DB_PASSWORD=.*/DB_PASSWORD=$db_pass/" .env

print_success "Database configuration updated"
echo ""

# Run migrations
print_step "Running database migrations..."
php artisan migrate:fresh --seed
print_success "Database migrations completed"
echo ""

# Create storage link
print_step "Creating storage link..."
php artisan storage:link
print_success "Storage link created"
echo ""

# Build assets
print_step "Building frontend assets..."
npm run build
print_success "Assets built"
echo ""

# Final summary
echo "=========================================="
echo -e "${GREEN}Installation Complete!${NC}"
echo "=========================================="
echo ""
echo "To start the development server, run:"
echo -e "${BLUE}php artisan serve${NC}"
echo ""
echo "Then visit: http://localhost:8000"
echo ""
echo "Test Accounts:"
echo "  Admin: admin@fededge.com"
echo "  Password: password"
echo ""
echo "For more information, see README.md and SETUP_GUIDE.md"
echo ""
