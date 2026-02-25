# St. Johns Church Management System

A comprehensive Laravel-based web application for managing church operations including member registration, event/service management, group coordination, financial giving/tithes, and administrative notifications.

## Table of Contents

- [Overview](#overview)
- [Key Features](#key-features)
- [Technology Stack](#technology-stack)
- [System Architecture](#system-architecture)
- [Installation](#installation)
- [Configuration](#configuration)
- [Database Structure](#database-structure)
- [User Roles & Permissions](#user-roles--permissions)
- [Core Modules](#core-modules)
- [External Integrations](#external-integrations)
- [Development](#development)
- [Testing](#testing)

## Overview

St. Johns Church Management System is a full-featured church administration platform that streamlines member management, event coordination, financial tracking, and communication. The system supports both authenticated members and guest users, with a comprehensive admin dashboard for church leadership.

## Key Features

### Member Management
- Member registration with profile management
- Profile image uploads (Supabase cloud storage)
- Newsletter subscription integration (MailerLite)
- Member analytics and engagement metrics
- Cell group assignment (North, East, South, West)
- Optional user account linking for portal access

### Event & Service Management
- Create and manage church events and announcements
- Event registration for members and guests
- Service registration with payment tracking
- Event pinning and expiration dates
- Bulk operations (delete, activate, deactivate)
- Image uploads for events
- QR code generation for easy registration

### Financial Management (Giving/Tithe System)
- Multiple giving types: Tithe, Offering, Donation, Special Offering
- Payment methods: Cash, Mobile Money (MTN/Airtel), Bank Transfer, Card, Check
- Transaction reference tracking
- Admin verification and confirmation workflow
- Automated receipt generation and email delivery
- Processing fee calculation
- CSV export for financial reporting
- Member giving history with yearly totals
- Dashboard summary with current month statistics

### Group Management
- Cell group creation and management
- Member approval workflow (Pending → Approved)
- Group information: Name, description, meeting day, location, image
- Member listing with approval status
- Active/inactive group status

### Admin Dashboard
- Real-time statistics and metrics
- Member engagement analytics
- Interactive charts (Bar, Pie, Doughnut)
- Monthly registration trends
- Service and event registration tracking
- Quick access to recent activities

### Notification System
- Database-driven admin notifications
- Real-time notification count
- Notification types:
  - New member registrations
  - Giving submissions
  - Service registrations
  - Payment proof submissions
  - Group join requests
- Bulk operations (mark all read, bulk delete)

### QR Code Generation
- Member registration QR codes
- Event registration QR codes
- Giving/donation QR codes
- Custom URL QR codes
- Downloadable PNG format

## Technology Stack

### Backend
- **Framework**: Laravel 12.x
- **PHP**: 8.2+
- **Database**: MySQL
- **Authentication**: Laravel Breeze
- **Queue**: Database driver
- **Storage**: Supabase (S3-compatible) with local fallback

### Frontend
- **Templating**: Blade
- **CSS Framework**: Tailwind CSS
- **JavaScript**: Alpine.js (via Breeze)
- **Build Tool**: Vite
- **Charts**: Chart.js

### External Services
- **MailerLite**: Newsletter subscription management
- **Supabase**: Cloud storage for member images
- **Email**: SMTP for receipts and notifications

### Development Tools
- **Testing**: Pest PHP with property-based testing (Eris)
- **Code Quality**: Laravel Pail for log monitoring
- **Package Manager**: Composer
- **Asset Management**: NPM

## System Architecture

### Database Design Principles
- **Referential Integrity**: Foreign key constraints on all relationships
- **Performance Optimized**: Strategic indexes on frequently queried columns
- **Data Safety**: Soft deletes on critical entities (Members, Events, Givings)
- **Scalability**: Normalized structure to support growth
- **Laravel Conventions**: Follows Laravel naming standards

### Key Relationships
```
User (1:1 optional) ↔ Member
Member (1:many) → Givings
Member (1:many) → EventRegistrations
Member (1:many) → ServiceRegistrations
Member (many:many) ↔ Groups (with approval pivot)
Event (1:many) → EventRegistrations
Service (1:many) → ServiceRegistrations
User (1:many) → Events (created_by)
User (1:many) → Notifications
```

### Application Layers
1. **Routes** (`routes/web.php`): Public and admin route definitions
2. **Controllers**: Business logic and request handling
   - Public controllers for member-facing features
   - Admin controllers for administrative functions
3. **Models**: Eloquent ORM models with relationships
4. **Services**: Reusable business logic (MailerLite, Notifications)
5. **Notifications**: Database notification classes
6. **Policies**: Authorization logic (e.g., GivingPolicy)
7. **Middleware**: Authentication and admin role checking
8. **Views**: Blade templates for UI rendering

## Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js & NPM
- MySQL 5.7+ or MariaDB 10.3+
- Git

### Quick Setup

```bash
# Clone the repository
git clone <repository-url>
cd church-management-system

# Install dependencies and setup
composer setup

# This runs:
# - composer install
# - Copy .env.example to .env
# - php artisan key:generate
# - php artisan migrate --force
# - npm install
# - npm run build
```

### Manual Setup

```bash
# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure your database in .env
# Then run migrations
php artisan migrate

# Seed the database (optional)
php artisan db:seed

# Build frontend assets
npm run build
```

## Configuration

### Environment Variables

Edit `.env` file with your configuration:

#### Application
```env
APP_NAME="St. Johns Church"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourchurch.com
```

#### Database
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=church_db
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

#### Mail Configuration
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS="noreply@yourchurch.com"
MAIL_FROM_NAME="${APP_NAME}"
```

#### Supabase Storage (for member images)
```env
SUPABASE_ACCESS_KEY_ID=your_access_key
SUPABASE_SECRET_ACCESS_KEY=your_secret_key
SUPABASE_ENDPOINT=https://your-project.supabase.co/storage/v1/s3
SUPABASE_PUBLIC_URL=https://your-project.supabase.co/storage/v1/object/public/
```

#### MailerLite Integration
```env
MAILERLITE_API_KEY=your_api_key
MAILERLITE_GROUP_ID=your_group_id
```

#### Queue Configuration
```env
QUEUE_CONNECTION=database
```

### Creating Admin User

```bash
# Run the admin seeder
php artisan db:seed --class=AdminSeeder

# Or create manually via tinker
php artisan tinker
>>> User::create([
    'name' => 'Admin User',
    'email' => 'admin@yourchurch.com',
    'password' => bcrypt('password'),
    'role' => 'admin'
]);
```

## Database Structure

### Core Tables

#### users
- Authentication and system access
- Roles: `user`, `admin`
- Optional 1:1 relationship with members

#### members
- Church membership records
- Fields: full_name, date_of_birth, gender, marital_status, phone, email, address, date_joined, cell, profile_image
- Soft deletes enabled
- Newsletter subscription tracking

#### events
- Church events and announcements
- Fields: title, slug, description, content, type, category, date, time, location, starts_at, ends_at, expires_at, image, is_pinned, is_active
- Soft deletes enabled
- Created by admin users

#### services
- Church services/programs
- Fields: name, description, schedule, fee, is_free, currency
- Related to service registrations

#### givings
- Financial contributions tracking
- Fields: member_id, guest_name, guest_email, giving_type, amount, currency, purpose, payment_method, transaction_reference, status, receipt_number
- Soft deletes enabled
- Admin confirmation workflow

#### groups
- Cell groups management
- Fields: name, description, meeting_day, location, is_active, sort_order, icon, image_url, category
- Many-to-many with members (with approval pivot)

#### event_registrations
- Event attendance tracking
- Links members/guests to events

#### service_registrations
- Service participation tracking
- Payment proof submission
- Admin approval workflow

#### notifications
- Database notifications for admins
- Polymorphic notification system

### Pivot Tables
- `group_member`: Links members to groups with approval status

## User Roles & Permissions

### Admin Role
- Full system access
- Dashboard with analytics
- Member management (view, edit, delete)
- Event/Service CRUD operations
- Group management with member approval
- Giving verification and confirmation
- Notification management
- Newsletter subscriber management
- QR code generation
- Global search functionality

### Member Role (Authenticated Users)
- Register for events and services
- Submit giving/donations
- View personal giving history
- Manage profile and newsletter subscription
- Join cell groups (pending approval)
- Upload profile image

### Guest Role (Unauthenticated)
- Register for events (with name, email, phone)
- Register for services
- Submit giving/donations (with guest details)
- View public pages (home, events, services)

## Core Modules

### 1. Member Module

**Controllers**: `MemberController`, `ProfileController`

**Key Features**:
- Member registration form with validation
- Profile image upload to Supabase
- Cell group assignment
- Newsletter subscription toggle
- Member dashboard with statistics
- Member listing with search and filters
- Export functionality

**Routes**:
```php
GET  /members/register          // Registration form
POST /members                   // Store new member
GET  /profile                   // Edit profile
PATCH /profile                  // Update profile
PATCH /profile/newsletter       // Toggle newsletter
```

### 2. Event Module

**Controllers**: `Admin/EventController`, `EventController`, `EventRegistrationController`

**Key Features**:
- Event CRUD operations (admin)
- Event listing with filters (type, category, date)
- Event registration for members and guests
- Image uploads for events
- Pinning and expiration management
- Bulk operations (delete, activate, deactivate)
- QR code generation for events

**Routes**:
```php
// Public
GET  /events                    // List events
GET  /events/{slug}             // View event
POST /events/{event}/register   // Register for event

// Admin
GET  /admin/events              // Manage events
POST /admin/events              // Create event
PUT  /admin/events/{id}         // Update event
DELETE /admin/events/{id}       // Delete event
POST /admin/events/bulk-delete  // Bulk delete
```

### 3. Service Module

**Controllers**: `Admin/ServiceController`, `ServiceController`, `ServiceRegistrationController`

**Key Features**:
- Service CRUD operations (admin)
- Service registration with payment tracking
- Payment proof submission
- Admin payment confirmation
- Receipt generation and email
- Registration status tracking

**Routes**:
```php
// Public
GET  /services                          // List services
POST /services/{service}/register       // Register for service
POST /service-registrations/{id}/payment // Submit payment proof

// Admin
GET  /admin/services                    // Manage services
POST /admin/services                    // Create service
PUT  /admin/services/{id}               // Update service
DELETE /admin/services/{id}             // Delete service
POST /admin/services/registrations/{id}/confirm // Confirm payment
```

### 4. Giving Module

**Controllers**: `GivingController`, `Admin/GivingController`

**Key Features**:
- Public giving form (members and guests)
- Multiple payment methods
- Transaction reference tracking
- Admin verification workflow
- Receipt generation with unique receipt numbers
- Email receipt delivery
- Giving history for members
- CSV export for reporting
- Dashboard summary

**Routes**:
```php
// Public
GET  /give                      // Giving form
POST /givings                   // Submit giving
GET  /givings/history           // Member giving history

// Admin
GET  /admin/givings             // Manage givings
POST /admin/givings/{id}/verify // Verify giving
GET  /admin/givings/reports     // Financial reports
GET  /admin/givings/export      // CSV export
```

### 5. Group Module

**Controllers**: `Admin/GroupController`, `GroupJoinController`

**Key Features**:
- Group CRUD operations (admin)
- Member approval workflow
- Group listing with active/inactive status
- Member join requests
- Approval/rejection by admin
- Group member listing

**Routes**:
```php
// Public
GET  /groups                    // List groups
POST /groups/{group}/join       // Join group

// Admin
GET  /admin/groups              // Manage groups
POST /admin/groups              // Create group
PUT  /admin/groups/{id}         // Update group
DELETE /admin/groups/{id}       // Delete group
POST /admin/groups/{group}/members/{member}/approve // Approve member
POST /admin/groups/{group}/members/{member}/reject  // Reject member
```

### 6. Notification Module

**Controllers**: `NotificationController`

**Key Features**:
- Real-time notification count
- Unread notifications listing
- Mark as read (single/all)
- Delete notifications (single/bulk)
- Notification detail view
- Auto-refresh notification count

**Routes**:
```php
GET  /notifications                     // List all notifications
GET  /api/notifications/unread-count    // Get unread count
GET  /api/notifications/unread          // Get unread notifications
POST /api/notifications/{id}/read       // Mark as read
POST /api/notifications/read-all        // Mark all as read
DELETE /api/notifications/{id}          // Delete notification
POST /api/notifications/bulk-delete     // Bulk delete
```

### 7. QR Code Module

**Controllers**: `QRCodeController`

**Key Features**:
- Generate QR codes for various purposes
- Member registration QR codes
- Event registration QR codes
- Giving/donation QR codes
- Custom URL QR codes
- Downloadable PNG format

**Routes**:
```php
GET /qr-code/member-registration    // Member registration QR
GET /qr-code/event/{event}          // Event registration QR
GET /qr-code/giving                 // Giving QR
GET /qr-code/custom                 // Custom URL QR
```

## External Integrations

### MailerLite Integration

**Service**: `App\Services\MailerLiteService`

**Features**:
- Subscribe members to newsletter
- Unsubscribe members from newsletter
- Custom fields support (member_status)
- Comprehensive logging
- Error handling with retries

**Configuration**:
```php
// config/mailerlite.php
'api_key' => env('MAILERLITE_API_KEY'),
'group_id' => env('MAILERLITE_GROUP_ID'),
'api_base_url' => 'https://api.mailerlite.com/api/v2/',
```

**Usage**:
```php
use App\Services\MailerLiteService;

$mailerLite = new MailerLiteService();

// Subscribe
$mailerLite->subscribe('member@example.com', [
    'name' => 'John Doe',
    'member_status' => 'member'
]);

// Unsubscribe
$mailerLite->unsubscribe('member@example.com');
```

### Supabase Storage

**Configuration**:
```php
// config/filesystems.php
'supabase' => [
    'driver' => 's3',
    'key' => env('SUPABASE_ACCESS_KEY_ID'),
    'secret' => env('SUPABASE_SECRET_ACCESS_KEY'),
    'region' => 'auto',
    'bucket' => 'member-images',
    'endpoint' => env('SUPABASE_ENDPOINT'),
    'url' => env('SUPABASE_PUBLIC_URL'),
],
```

**Usage**:
```php
// Upload member profile image
Storage::disk('supabase')->put($path, $file);

// Get public URL
$url = Storage::disk('supabase')->url($path);
```

### Email System

**Mailable Classes**:
- `GivingReceiptMail`: Sending giving receipts
- `ServiceRegistrationReceipt`: Service registration confirmations

**Configuration**: Standard Laravel mail configuration in `.env`

## Development

### Running the Development Server

```bash
# Start all development services (server, queue, logs, vite)
composer dev

# This runs concurrently:
# - php artisan serve (web server)
# - php artisan queue:listen (queue worker)
# - php artisan pail (log monitoring)
# - npm run dev (vite dev server)
```

### Manual Development Commands

```bash
# Start web server
php artisan serve

# Start queue worker
php artisan queue:listen

# Watch for file changes (Vite)
npm run dev

# Monitor logs
php artisan pail
```

### Database Management

```bash
# Run migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback

# Fresh migration with seeding
php artisan migrate:fresh --seed

# Seed specific seeder
php artisan db:seed --class=AdminSeeder
```

### Cache Management

```bash
# Clear all caches
php artisan optimize:clear

# Clear specific caches
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
```

### Code Quality

```bash
# Run tests
composer test

# Run specific test
php artisan test --filter=GivingTest

# Generate IDE helper files
php artisan ide-helper:generate
php artisan ide-helper:models
```

## Testing

### Test Framework
- **Pest PHP**: Modern testing framework
- **Property-Based Testing**: Using Eris for comprehensive test coverage

### Running Tests

```bash
# Run all tests
composer test
# or
php artisan test

# Run specific test file
php artisan test tests/Feature/GivingTest.php

# Run with coverage
php artisan test --coverage

# Run specific test method
php artisan test --filter=test_member_can_submit_giving
```

### Test Structure

```
tests/
├── Feature/          # Feature tests (HTTP, database)
│   ├── GivingTest.php
│   ├── MemberTest.php
│   ├── EventTest.php
│   └── ...
├── Unit/             # Unit tests (isolated logic)
│   ├── Services/
│   └── Models/
└── TestCase.php      # Base test case
```

### Property-Based Testing

The system includes property-based testing using Eris for comprehensive validation:

```php
// Example: Testing giving amount validation
$this->forAll(
    Generator\choose(100, 100000000)
)->then(function ($amount) {
    $response = $this->post('/givings', [
        'amount' => $amount,
        'giving_type' => 'tithe',
        // ...
    ]);
    
    $response->assertStatus(200);
});
```

## Project Structure

```
church-management-system/
├── app/
│   ├── Console/Commands/       # Artisan commands
│   ├── Http/
│   │   ├── Controllers/        # Application controllers
│   │   │   ├── Admin/          # Admin controllers
│   │   │   └── Auth/           # Authentication controllers
│   │   ├── Middleware/         # Custom middleware
│   │   └── Requests/           # Form request validation
│   ├── Mail/                   # Mailable classes
│   ├── Models/                 # Eloquent models
│   ├── Notifications/          # Notification classes
│   ├── Policies/               # Authorization policies
│   ├── Services/               # Business logic services
│   └── View/Components/        # Blade components
├── bootstrap/                  # Application bootstrap
├── config/                     # Configuration files
├── database/
│   ├── factories/              # Model factories
│   ├── migrations/             # Database migrations
│   └── seeders/                # Database seeders
├── public/                     # Public assets
├── resources/
│   ├── css/                    # Stylesheets
│   ├── js/                     # JavaScript files
│   └── views/                  # Blade templates
│       ├── admin/              # Admin views
│       ├── auth/               # Authentication views
│       ├── layouts/            # Layout templates
│       └── partials/           # Reusable partials
├── routes/
│   └── web.php                 # Web routes
├── storage/                    # Application storage
├── tests/                      # Test files
├── .env.example                # Environment template
├── composer.json               # PHP dependencies
├── package.json                # Node dependencies
└── README.md                   # This file
```

## Common Tasks

### Adding a New Admin User

```bash
php artisan tinker
>>> User::create(['name' => 'Admin', 'email' => 'admin@church.com', 'password' => bcrypt('password'), 'role' => 'admin']);
```

### Resetting a User Password

```bash
php artisan tinker
>>> $user = User::where('email', 'user@church.com')->first();
>>> $user->password = bcrypt('newpassword');
>>> $user->save();
```

### Exporting Giving Records

Navigate to: `/admin/givings/reports` and click "Export to CSV"

### Viewing Logs

```bash
# Real-time log monitoring
php artisan pail

# View log files
tail -f storage/logs/laravel.log
```

### Clearing Queue Jobs

```bash
# Clear failed jobs
php artisan queue:flush

# Retry failed jobs
php artisan queue:retry all
```

## Troubleshooting

### Issue: Images not uploading

**Solution**: Check Supabase configuration in `.env` and ensure bucket permissions are correct.

```bash
# Test Supabase connection
php artisan tinker
>>> Storage::disk('supabase')->put('test.txt', 'test');
```

### Issue: Queue jobs not processing

**Solution**: Ensure queue worker is running.

```bash
# Start queue worker
php artisan queue:listen

# Or use supervisor in production
```

### Issue: MailerLite subscription failing

**Solution**: Check API key and group ID in `.env`. View logs:

```bash
tail -f storage/logs/mailerlite.log
```

### Issue: Permission denied errors

**Solution**: Fix storage permissions.

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

## Security Considerations

- All user inputs are validated using Form Requests
- CSRF protection enabled on all forms
- SQL injection prevention via Eloquent ORM
- XSS protection via Blade templating
- Password hashing using bcrypt
- Role-based access control (admin middleware)
- Soft deletes to prevent accidental data loss
- Transaction reference validation for payments
- Email verification for sensitive operations

## Performance Optimization

- Database indexes on frequently queried columns
- Eager loading to prevent N+1 queries
- Query result caching where appropriate
- Asset compilation and minification (Vite)
- Image optimization for uploads
- Queue system for async operations (emails, notifications)

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License.

## Support

For support, please contact the development team or open an issue in the repository.

---

**Built with ❤️ for St. Johns Church**
