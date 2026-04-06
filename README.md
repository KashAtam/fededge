# Fededge - Vehicle Registration & Compliance Management System

<div style="text-align: center;">

![Fededge](https://img.shields.io/badge/Fededge-Vehicle%20Management-d32f2f?style=flat-square)
![Laravel](https://img.shields.io/badge/Laravel-11.x-d32f2f?style=flat-square)
![PHP](https://img.shields.io/badge/PHP-8.2%2B-informational?style=flat-square)
![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)

A comprehensive, professional-grade vehicle registration and compliance management system built with Laravel, featuring role-based access control, document management, and real-time compliance verification.

</div>

---

## Table of Contents

- [Features](#features)
- [System Requirements](#system-requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Project Structure](#project-structure)
- [Database Schema](#database-schema)
- [API Endpoints](#api-endpoints)
- [User Roles & Permissions](#user-roles--permissions)
- [Document Management](#document-management)
- [Compliance System](#compliance-system)
- [Notifications](#notifications)
- [Troubleshooting](#troubleshooting)
- [Contributing](#contributing)
- [License](#license)

---

## Features

### 🎯 Core Features

- **Role-Based Access Control**
  - Admin Dashboard with comprehensive statistics and analytics
  - Vehicle Owner Portal for managing vehicles and documents
  - Road Officer Verification System for quick vehicle compliance checks

- **Vehicle Management**
  - Register and manage multiple vehicles per account
  - Track vehicle details (plate number, VIN, engine number, etc.)
  - Real-time compliance status monitoring

- **Document Management System**
  - Upload and manage 6 types of documents:
    - Driver's License
    - Vehicle License
    - Insurance Certificate
    - Roadworthiness Certificate
    - Registration Certificate
    - Inspection Report
  - Admin review and approval workflow
  - Document expiry tracking and alerts

- **Compliance Verification**
  - Automatic compliance status calculation
  - Document expiry monitoring
  - Real-time alerts for expiring documents
  - Compliance metrics and reporting

- **User Interface**
  - Professional, responsive design
  - Light/Dark mode support
  - Mobile-friendly interface
  - Bootstrap 5 styling
  - Chart.js analytics integration

- **Security**
  - Laravel Breeze authentication
  - Password hashing with bcrypt
  - CSRF protection
  - File upload validation
  - Role-based middleware protection

---

## System Requirements

### Minimum Requirements

- **PHP**: 8.2 or higher
- **Laravel**: 11.x
- **Database**: MySQL 8.0+ or MariaDB 10.4+
- **Node.js**: 16.0+ (for asset compilation)
- **Composer**: 2.0+

### Recommended Requirements

- **PHP**: 8.3+
- **MySQL**: 8.0+
- **Node.js**: 18.0+
- **NPM**: 9.0+ or PNPM 7.0+

### Optional Requirements

- **Docker**: For containerized deployment
- **Redis**: For caching and queues
- **AWS S3**: For file storage

---

## Installation

### Step 1: Clone the Repository

```bash
git clone https://github.com/yourusername/fededge.git
cd fededge
```

### Step 2: Install PHP Dependencies

```bash
composer install
```

### Step 3: Install Node Dependencies

```bash
npm install
# or
pnpm install
```

### Step 4: Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` file and configure:

```env
APP_NAME=Fededge
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fededge
DB_USERNAME=root
DB_PASSWORD=password

# File Storage
FILESYSTEM_DISK=local
# For S3: uncomment and configure
# AWS_ACCESS_KEY_ID=your_key
# AWS_SECRET_ACCESS_KEY=your_secret
# AWS_DEFAULT_REGION=us-east-1
# AWS_BUCKET=your_bucket
```

### Step 5: Create Database

```bash
mysql -u root -p -e "CREATE DATABASE fededge;"
```

### Step 6: Run Migrations

```bash
php artisan migrate
```

### Step 7: Seed Test Data

```bash
php artisan db:seed
```

### Step 8: Build Assets

```bash
npm run build
# or for development
npm run dev
```

### Step 9: Create Storage Link

```bash
php artisan storage:link
```

### Step 10: Start the Application

```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

---

## Configuration

### Environment Variables

Key environment variables to configure:

```env
# Application
APP_NAME=Fededge
APP_ENV=production  # or local
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Database
DB_CONNECTION=mysql
DB_HOST=your_host
DB_DATABASE=fededge
DB_USERNAME=user
DB_PASSWORD=password

# Email (for notifications)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password

# File Storage
FILESYSTEM_DISK=local
# or for S3
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=your_key
AWS_SECRET_ACCESS_KEY=your_secret
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your_bucket
```

### Database Configuration

The application uses the following database structure:

**Users Table:**
- Stores user accounts with role-based access
- Roles: admin, vehicle_owner, road_officer

**Vehicles Table:**
- Vehicle registration information
- Foreign key to users (owner_id)
- Status tracking (active, inactive, suspended)

**Documents Table:**
- Uploaded documents with metadata
- Foreign key to vehicles
- Approval workflow tracking

**Notifications Table:**
- User notifications (read/unread)
- Related resource tracking

---

## Usage

### First Time Setup

1. **Access Admin Panel**
   ```
   Email: admin@fededge.com
   Password: password
   URL: http://localhost:8000/admin/dashboard
   ```

2. **Create Vehicle Owner Account**
   - Navigate to registration or admin panel
   - Set role to "Vehicle Owner"

3. **Create Road Officer Account**
   - Navigate to registration or admin panel
   - Set role to "Road Officer"

### Vehicle Owner Workflow

1. **Login**: Access http://localhost:8000 with owner credentials
2. **Add Vehicle**: Navigate to "My Vehicles" → "Add Vehicle"
3. **Upload Documents**:
   - Select vehicle
   - Click "Upload Document"
   - Choose document type and file
   - Set issue and expiry dates
4. **Monitor Compliance**: Check compliance status in dashboard
5. **Receive Alerts**: Get notified about expiring documents

### Admin Workflow

1. **Access Admin Panel**: http://localhost:8000/admin/dashboard
2. **Review Documents**:
   - Navigate to "Documents"
   - Review pending documents
   - Approve or reject with feedback
3. **Manage Users**:
   - View all users
   - Change user roles
4. **Monitor Vehicles**: Track vehicle compliance across the system
5. **View Analytics**: Check dashboards and statistics

### Road Officer Workflow

1. **Access Verification**: http://localhost:8000/verification/dashboard
2. **Search Vehicle**:
   - Enter plate number or VIN
   - View vehicle details and compliance status
3. **Verify Compliance**:
   - Check document status
   - Verify all required documents are valid
4. **Generate Report**: Print or save verification report

---

## Project Structure

```
fededge/
├── app/
│   ├── Http/
│   │   ├── Controllers/          # Application controllers
│   │   │   ├── AdminDashboardController.php
│   │   │   ├── VehicleController.php
│   │   │   ├── DocumentController.php
│   │   │   └── RoadOfficerController.php
│   │   ├── Middleware/           # Custom middleware
│   │   │   ├── CheckRole.php
│   │   │   ├── EnsureUserIsAdmin.php
│   │   │   └── ...
│   │   └── Requests/             # Form requests (optional)
│   ├── Models/                   # Eloquent models
│   │   ├── User.php
│   │   ├── Vehicle.php
│   │   ├── Document.php
│   │   └── Notification.php
│   ├── Policies/                 # Authorization policies
│   │   ├── VehiclePolicy.php
│   │   └── DocumentPolicy.php
│   ├── Services/                 # Business logic services
│   └── Providers/                # Service providers
├── database/
│   ├── migrations/               # Database migrations
│   ├── factories/                # Model factories
│   └── seeders/                  # Database seeders
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   └── app.blade.php    # Main layout
│   │   ├── admin/                # Admin views
│   │   ├── vehicle-owner/        # Owner views
│   │   └── road-officer/         # Officer views
│   ├── css/                      # Stylesheets
│   └── js/                       # JavaScript
├── routes/
│   └── web.php                   # Web routes
├── config/                       # Configuration files
├── storage/
│   └── app/                      # File storage
├── .env                          # Environment variables
├── composer.json                 # PHP dependencies
├── package.json                  # Node dependencies
└── README.md                     # This file
```

---

## Database Schema

### Users Table

```sql
CREATE TABLE users (
  id BIGINT UNSIGNED PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin', 'vehicle_owner', 'road_officer') DEFAULT 'vehicle_owner',
  phone VARCHAR(20),
  address TEXT,
  email_verified_at TIMESTAMP NULL,
  remember_token VARCHAR(100),
  created_at TIMESTAMP,
  updated_at TIMESTAMP
);
```

### Vehicles Table

```sql
CREATE TABLE vehicles (
  id BIGINT UNSIGNED PRIMARY KEY,
  plate_number VARCHAR(20) UNIQUE NOT NULL,
  vehicle_type VARCHAR(50) NOT NULL,
  brand_model VARCHAR(100) NOT NULL,
  year_of_manufacture INT NOT NULL,
  vin VARCHAR(50),
  engine_number VARCHAR(50),
  color VARCHAR(50),
  engine_capacity DECIMAL(5, 2),
  owner_id BIGINT UNSIGNED NOT NULL,
  status ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
  created_at TIMESTAMP,
  updated_at TIMESTAMP,
  FOREIGN KEY (owner_id) REFERENCES users(id)
);
```

### Documents Table

```sql
CREATE TABLE documents (
  id BIGINT UNSIGNED PRIMARY KEY,
  vehicle_id BIGINT UNSIGNED NOT NULL,
  document_type ENUM(...) NOT NULL,
  file_path VARCHAR(255) NOT NULL,
  original_filename VARCHAR(255),
  issue_date DATE NOT NULL,
  expiry_date DATE NOT NULL,
  status ENUM('pending', 'approved', 'rejected', 'expired'),
  admin_feedback TEXT,
  approved_by BIGINT UNSIGNED,
  approved_at TIMESTAMP NULL,
  created_at TIMESTAMP,
  updated_at TIMESTAMP,
  FOREIGN KEY (vehicle_id) REFERENCES vehicles(id),
  FOREIGN KEY (approved_by) REFERENCES users(id)
);
```

### Notifications Table

```sql
CREATE TABLE notifications (
  id BIGINT UNSIGNED PRIMARY KEY,
  user_id BIGINT UNSIGNED NOT NULL,
  title VARCHAR(255) NOT NULL,
  message TEXT NOT NULL,
  type VARCHAR(50) DEFAULT 'info',
  related_type VARCHAR(50),
  related_id BIGINT UNSIGNED,
  read_at TIMESTAMP NULL,
  created_at TIMESTAMP,
  updated_at TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id)
);
```

---

## API Endpoints

### Authentication

```
POST   /api/login                 # User login
POST   /api/logout                # User logout
POST   /api/register              # User registration
```

### Vehicles

```
GET    /api/vehicles              # List vehicles
POST   /api/vehicles              # Create vehicle
GET    /api/vehicles/{id}         # Get vehicle
PUT    /api/vehicles/{id}         # Update vehicle
DELETE /api/vehicles/{id}         # Delete vehicle
```

### Documents

```
GET    /api/documents             # List documents
POST   /api/documents             # Upload document
GET    /api/documents/{id}        # Get document
DELETE /api/documents/{id}        # Delete document
GET    /api/documents/{id}/download # Download document
```

### Admin

```
GET    /api/admin/dashboard       # Admin statistics
GET    /api/admin/vehicles        # All vehicles
GET    /api/admin/users           # All users
GET    /api/admin/documents       # All documents
POST   /api/admin/documents/{id}/approve  # Approve
POST   /api/admin/documents/{id}/reject   # Reject
```

---

## User Roles & Permissions

### Admin
- ✅ Create, read, update, delete users
- ✅ Create, read, update, delete vehicles
- ✅ Approve/reject documents
- ✅ View all analytics and reports
- ✅ Manage system settings

### Vehicle Owner
- ✅ Create, read, update, delete own vehicles
- ✅ Upload documents for own vehicles
- ✅ View own documents
- ✅ Receive notifications
- ❌ Cannot approve documents
- ❌ Cannot delete own account

### Road Officer
- ✅ Search for vehicles
- ✅ View vehicle details and compliance status
- ✅ View document status
- ✅ Generate verification reports
- ❌ Cannot modify vehicle data
- ❌ Cannot upload documents

---

## Document Management

### Supported Document Types

1. **Driver's License** - Personal driver identification
2. **Vehicle License** - Vehicle registration license
3. **Insurance Certificate** - Vehicle insurance proof
4. **Roadworthiness Certificate** - Vehicle fitness certificate
5. **Registration Certificate** - Official registration document
6. **Inspection Report** - Vehicle inspection results

### Document Upload Requirements

- **Formats**: PDF, JPG, JPEG, PNG
- **Max Size**: 5MB per document
- **Required Fields**:
  - Document type
  - Issue date
  - Expiry date
  - Document file

### Document Approval Workflow

1. Vehicle owner uploads document
2. Document enters "Pending" status
3. Admin reviews document
4. Admin approves (→ "Approved") or rejects (→ "Rejected")
5. Owner receives notification
6. System automatically marks as "Expired" after expiry date

---

## Compliance System

### Compliance Determination

A vehicle is **compliant** when:
- ✅ Vehicle License is approved and not expired
- ✅ Insurance Certificate is approved and not expired
- ✅ Roadworthiness Certificate is approved and not expired

A vehicle is **non-compliant** when:
- ❌ Any required document is missing
- ❌ Any required document is expired
- ❌ Any required document is pending approval
- ❌ Any required document is rejected

### Compliance Alerts

The system automatically generates alerts for:
- Documents expiring within 7 days
- Expired documents
- Missing required documents
- Rejected documents awaiting reupload

---

## Notifications

### Types of Notifications

1. **Document Approved**: When admin approves a document
2. **Document Rejected**: When admin rejects a document
3. **Document Expiring**: 7 days before document expiry
4. **Vehicle Non-Compliant**: When vehicle loses compliance status
5. **System Alert**: Critical system messages

### Notification Delivery

- **In-App**: Stored in notifications table
- **Email**: Optional email notifications (configure MAIL_*)
- **Real-time**: Push notifications (optional enhancement)

---

## Troubleshooting

### Common Issues

#### 1. Database Connection Error
```
SOLUTION: Check .env DB_* variables match your MySQL configuration
php artisan migrate --fresh
```

#### 2. File Upload Fails
```
SOLUTION: Ensure storage directory is writable
php artisan storage:link
chmod -R 775 storage/
```

#### 3. Assets Not Loading
```
SOLUTION: Rebuild assets
npm run build
php artisan view:clear
php artisan cache:clear
```

#### 4. Login Issues
```
SOLUTION: Run fresh migrations and seed
php artisan migrate:fresh --seed
```

#### 5. Permission Denied Errors
```
SOLUTION: Check authorization policies
Review VehiclePolicy.php and DocumentPolicy.php
```

### Performance Optimization

1. **Cache Configuration**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

2. **Database Optimization**
   ```sql
   ANALYZE TABLE users;
   ANALYZE TABLE vehicles;
   ANALYZE TABLE documents;
   ```

3. **Enable Query Caching** (in .env)
   ```env
   CACHE_DRIVER=redis
   QUEUE_CONNECTION=redis
   ```

---

## Deployment

### Docker Deployment

```bash
docker-compose up -d
docker-compose exec app php artisan migrate:fresh --seed
```

### Production Checklist

- [ ] Set `APP_DEBUG=false`
- [ ] Set `APP_ENV=production`
- [ ] Generate strong `APP_KEY`
- [ ] Configure proper database
- [ ] Setup email service (SMTP)
- [ ] Configure file storage (S3 or local)
- [ ] Enable HTTPS
- [ ] Setup SSL certificate
- [ ] Configure backups
- [ ] Setup monitoring and logging
- [ ] Configure rate limiting
- [ ] Setup queue workers (if using async)
- [ ] Configure caching layer (Redis)

---

## Contributing

Contributions are welcome! Please follow these guidelines:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit changes (`git commit -m 'Add amazing feature'`)
4. Push to branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

---

## License

This project is licensed under the MIT License - see the LICENSE file for details.

---

## Support

For issues, questions, or suggestions, please:

1. Check existing issues on GitHub
2. Review documentation
3. Create a new GitHub issue with detailed description
4. Contact support team

---

## Changelog

### Version 1.0.0 (Initial Release)
- ✅ Complete vehicle management system
- ✅ Document upload and approval workflow
- ✅ Role-based access control
- ✅ Compliance tracking
- ✅ Admin dashboard with analytics
- ✅ Road officer verification system
- ✅ Vehicle owner portal
- ✅ Responsive design with light/dark mode

---

## Roadmap

- [ ] API documentation with Swagger
- [ ] SMS notifications
- [ ] QR code generation for vehicles
- [ ] Mobile app
- [ ] Advanced reporting and exports
- [ ] Email reminders for expiring documents
- [ ] Two-factor authentication
- [ ] Document templates
- [ ] Vehicle photo gallery
- [ ] Audit logging

---

<div style="text-align: center;">

**Made with ❤️ by the Fededge Team**

For more information, visit [fededge.com](https://fededge.com)

</div>
