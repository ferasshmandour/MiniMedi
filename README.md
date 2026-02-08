# MiniMedi - Hospital Management System

A simple hospital management system built with Laravel 12 for learning core backend concepts, REST API development, and web dashboard implementation.

## 🎯 Features

### For Patients (API)

- Registration and authentication via REST API
- Book appointments with doctors
- View own appointments
- Cancel pending/confirmed appointments
- Access medical notes and reports

### For Doctors (Web Dashboard)

- Login and authentication
- View assigned appointments
- Add medical notes to appointments
- Upload medical reports and lab results
- Role-based access control

### For Admin (Web Dashboard)

- Complete system management
- Manage doctors and patients
- View all appointments
- Assign roles and permissions
- System overview and reports

## 🚀 Learning Requirements Implemented

### ✅ 1. ERD Design

- Complete Entity-Relationship Diagram in [`docs/ERD.md`](docs/ERD.md)
- Tables: Users, Doctors, Patients, Appointments, MedicalNotes, Roles
- Relationships: hasMany, belongsTo, hasOne

### ✅ 2. REST API for Patients

- Authentication (register, login, logout, profile)
- Appointment management (book, view, cancel)
- JSON responses with proper validation
- API routes in [`routes/api.php`](routes/api.php)

### ✅ 3. Localization

- English and Arabic translations
- Labels, statuses, and messages localized
- Configured in [`lang/en/`](lang/en/) and [`lang/ar/`](lang/ar/)

### ✅ 4. Role-Permission Example

- Custom role-permission system
- Roles table with JSON permissions
- Role assignment to users
- Permission checking in models
- Example: "Senior Doctor" role with special permissions

### ✅ 5. Media Upload (Spatie Media Library)

- File upload for appointments
- Medical reports and lab results
- Image support for prescriptions
- Configured collections with file type restrictions

### ✅ 6. Events, Observers, Queue & Job

- **Event**: `AppointmentCreated` event
- **Observer**: `AppointmentObserver` reacts to model changes
- **Job**: `SendAppointmentNotification` queued job
- **Queue**: Async processing with database queue
- **Task Schedule**: Daily appointment report command

## 📁 Project Structure

```
MiniMedi/
├── app/
│   ├── Console/
│   │   └── Commands/
│   │       └── DailyAppointmentReport.php
│   ├── Events/
│   │   └── AppointmentCreated.php
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/
│   │   │   │   ├── AuthController.php
│   │   │   │   └── AppointmentController.php
│   │   │   └── Controller.php
│   │   └── Middleware/
│   ├── Jobs/
│   │   └── SendAppointmentNotification.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Doctor.php
│   │   ├── Patient.php
│   │   ├── Appointment.php
│   │   ├── MedicalNote.php
│   │   └── Role.php
│   ├── Observers/
│   │   └── AppointmentObserver.php
│   └── Providers/
│       ├── AppServiceProvider.php
│       └── EventServiceProvider.php
├── config/
│   ├── app.php
│   └── media-library.php
├── database/
│   ├── migrations/
│   └── seeders/
│       └── DatabaseSeeder.php
├── docs/
│   └── ERD.md
├── lang/
│   ├── en/
│   │   └── messages.php
│   └── ar/
│       └── messages.php
├── routes/
│   ├── api.php
│   ├── web.php
│   └── console.php
└── resources/
    └── views/
```

## 🛠 Installation

### Prerequisites

- PHP 8.2+
- Composer
- MySQL/MariaDB
- Node.js & NPM (for frontend assets)

### Setup Steps

1. **Clone and Install Dependencies**

    ```bash
    cd hospital-management
    composer install
    npm install
    ```

2. **Environment Setup**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

3. **Configure Database**
   Edit `.env` file:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=hospital_management
    DB_USERNAME=root
    DB_PASSWORD=
    ```

4. **Run Migrations and Seeders**

    ```bash
    php artisan migrate --seed
    ```

5. **Start Development Server**
    ```bash
    php artisan serve
    ```

## 🔐 Default Test Users

| Role      | Email                | Password    |
| --------- | -------------------- | ----------- |
| Admin     | admin@hospital.com   | password123 |
| Doctor    | doctor@hospital.com  | password123 |
| Doctor 2  | doctor2@hospital.com | password123 |
| Patient   | patient@example.com  | password123 |
| Patient 2 | patient2@example.com | password123 |

## 📡 API Endpoints

### Authentication

```
POST /api/v1/auth/register    - Register new patient
POST /api/v1/auth/login      - Login
POST /api/v1/auth/logout     - Logout (requires auth)
GET  /api/v1/auth/profile     - Get user profile (requires auth)
```

### Appointments (Patient API)

```
GET  /api/v1/appointments                 - List own appointments
POST /api/v1/appointments                 - Book new appointment
GET  /api/v1/appointments/{id}            - View appointment details
POST /api/v1/appointments/{id}/cancel    - Cancel appointment
```

## 📅 Scheduled Tasks

### Daily Appointment Report

Runs daily at midnight:

```bash
php artisan appointments:daily-report
```

## 🧪 Testing

Run the test suite:

```bash
php artisan test
```

## 🔧 Queue Workers

Start the queue worker for processing background jobs:

```bash
php artisan queue:work
```

## 📖 Learning Resources

### Key Concepts Covered

1. **Laravel Basics**: Routes, Controllers, Models, Migrations
2. **Authentication**: Sanctum, Session management, API tokens
3. **REST API**: Resource controllers, JSON responses, Validation
4. **Database**: Eloquent relationships, Query builders, Migrations
5. **Events & Listeners**: Event-driven architecture
6. **Queues**: Database queue, Background jobs
7. **Scheduling**: Task scheduling, Cron jobs
8. **File Uploads**: Spatie Media Library, File validation
9. **Localization**: Multi-language support
10. **Role-Based Access**: Custom permission system

### Best Practices Implemented

- RESTful API design
- Proper error handling
- Input validation
- Code organization
- Security best practices
- Performance optimization

## 🚀 Deployment

### Production Setup

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

