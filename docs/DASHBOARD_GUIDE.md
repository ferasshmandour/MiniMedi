# MiniMedi Dashboard Guide

## 🌐 Accessing the Dashboard

The MiniMedi system provides both **Web Dashboard** and **REST API** interfaces:

### Web Dashboard URLs

- **Landing Page**: `http://127.0.0.1:8000/`
- **Dashboard**: `http://127.0.0.1:8000/dashboard`
- **Login**: `http://127.0.0.1:8000/login`

### REST API Base URL

- **API Base**: `http://127.0.0.1:8000/api/v1`
- **Documentation**: See `docs/API_TESTING.md`

---

## 🔐 Login Credentials

### Admin Access

| Field    | Value              |
| -------- | ------------------ |
| Email    | admin@hospital.com |
| Password | password123        |

### Doctor Access

| Field    | Value               |
| -------- | ------------------- |
| Email    | doctor@hospital.com |
| Password | password123         |

| Field    | Value                |
| -------- | -------------------- |
| Email    | doctor2@hospital.com |
| Password | password123          |

### Patient Access

| Field    | Value               |
| -------- | ------------------- |
| Email    | patient@example.com |
| Password | password123         |

| Field    | Value                |
| -------- | -------------------- |
| Email    | patient2@example.com |
| Password | password123          |

---

## 👨‍💼 Admin Dashboard

**URL**: `http://127.0.0.1:8000/dashboard` (when logged in as admin)

### Features

#### 1. Dashboard Overview

- View total counts: Admins, Doctors, Patients, Appointments
- Quick statistics on system usage
- Recent appointments list

#### 2. Doctor Management

**URL**: `http://127.0.0.1:8000/admin/doctors`

Features:

- View all doctors list
- Add new doctor with profile
- View doctor details
- See doctor specialization and department

#### 3. Patient Management

**URL**: `http://127.0.0.1:8000/admin/patients`

Features:

- View all patients list
- Add new patient with medical history
- View patient details and appointments

#### 4. Appointment Management

**URL**: `http://127.0.0.1:8000/admin/appointments`

Features:

- View all appointments (all users)
- Filter by status (pending, confirmed, completed, cancelled)
- Update appointment status
- View appointment details

#### 5. Roles & Permissions

**URL**: `http://127.0.0.1:8000/admin/roles`

Features:

- View all roles
- Create new role with custom permissions
- Assign permissions to roles
- View users with each role

---

## 👨‍⚕️ Doctor Dashboard

**URL**: `http://127.0.0.1:8000/dashboard` (when logged in as doctor)

### Features

#### 1. My Appointments

**URL**: `http://127.0.0.1:8000/doctor/appointments`

Features:

- View assigned appointments only
- Filter by status
- View patient details
- Add medical notes

#### 2. Medical Notes

**URL**: `http://127.0.0.1:8000/doctor/medical-notes`

Features:

- View all medical notes created
- Create new medical note for appointments
- Include diagnosis, prescription, treatment plan
- Add symptoms and vital signs
- Upload lab results and reports (using Spatie Media Library)

---

## 👤 Patient Dashboard

**URL**: `http://127.0.0.1:8000/dashboard` (when logged in as patient)

### Features

#### 1. My Appointments

**URL**: `http://127.0.0.1:8000/patient/appointments`

Features:

- View all own appointments
- See appointment status
- Cancel pending/confirmed appointments
- View doctor details

#### 2. Book Appointment

**URL**: `http://127.0.0.1:8000/patient/book-appointment`

Features:

- Select doctor from list
- Choose appointment date and time
- Provide reason for visit
- Receive confirmation

#### 3. Profile

**URL**: `http://127.0.0.1:8000/profile`

Features:

- View personal information
- See medical details (blood type, allergies)
- Update contact information

---

## 📡 REST API Endpoints

### Authentication

```http
POST /api/v1/auth/register
POST /api/v1/auth/login
POST /api/v1/auth/logout
GET  /api/v1/auth/profile
```

### Appointments

```http
GET  /api/v1/appointments          # List appointments
POST /api/v1/appointments          # Book appointment
GET  /api/v1/appointments/{id}     # View details
POST /api/v1/appointments/{id}/cancel
```

### Example API Usage

#### Register Patient

```bash
curl -X POST http://127.0.0.1:8000/api/v1/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "New Patient",
    "email": "new@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'
```

#### Login

```bash
curl -X POST http://127.0.0.1:8000/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "patient@example.com",
    "password": "password123"
  }'
```

#### Book Appointment (with token)

```bash
curl -X POST http://127.0.0.1:8000/api/v1/appointments \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "doctor_id": 2,
    "appointment_date": "2026-02-20 10:00:00",
    "reason": "Regular checkup"
  }'
```

---

## 🎨 Dashboard Features

### User Interface

- **Responsive Design**: Works on desktop and mobile
- **Modern Styling**: Clean, professional healthcare look
- **Role-Based Menu**: Different sidebar options per role
- **Quick Actions**: Easy access to common tasks
- **Status Badges**: Color-coded appointment statuses

### Dashboard Statistics

- **Admin**: Total counts of all users and appointments
- **Doctor**: Appointments breakdown by status
- **Patient**: Personal appointment history

### Quick Actions

- **Admin**: Manage doctors, patients, appointments
- **Doctor**: View appointments, create notes
- **Patient**: Book appointments, view history

---

## 🔧 Configuration

### Localization

The dashboard supports:

- **English (en)**: Default interface language
- **Arabic (ar)**: Full Arabic translation

Change language in `.env`:

```env
APP_LOCALE=en
APP_FALLBACK_LOCALE=en
```

### Database Queue

For background job processing:

```bash
php artisan queue:work
```

### Scheduled Tasks

Daily appointment report:

```bash
php artisan appointments:daily-report
```

---

## 📁 File Structure

```
resources/views/
├── layouts/
│   └── app.blade.php          # Main dashboard layout
├── dashboard/
│   └── index.blade.php        # Dashboard home page
├── auth/
│   └── login.blade.php        # Login page (to be created)
├── admin/
│   ├── doctors/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   └── show.blade.php
│   ├── patients/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   └── show.blade.php
│   ├── appointments/
│   │   └── index.blade.php
│   └── roles/
│       ├── index.blade.php
│       ├── create.blade.php
│       └── show.blade.php
├── doctor/
│   ├── appointments/
│   │   └── index.blade.php
│   └── medical-notes/
│       ├── index.blade.php
│       ├── create.blade.php
│       └── show.blade.php
├── patient/
│   ├── appointments/
│   │   └── index.blade.php
│   └── book-appointment.blade.php
└── appointments/
    └── show.blade.php
```

---

## 🚀 Getting Started

### 1. Start the Server

```bash
php artisan serve
```

### 2. Access the Dashboard

Open browser to: `http://127.0.0.1:8000/`

### 3. Login

Use any of the test credentials above

### 4. Explore Features

- Navigate through the sidebar
- Try different user roles
- Test API endpoints

---

## 📞 Support

### Documentation Files

- **Main README**: `README.md`
- **API Testing**: `docs/API_TESTING.md`
- **ERD Diagram**: `docs/ERD.md`
- **Project Summary**: `PROJECT_SUMMARY.md`
- **This Guide**: `docs/DASHBOARD_GUIDE.md`

### Common Issues

1. **Dashboard not loading**
    - Ensure server is running: `php artisan serve`
    - Check routes: `php artisan route:list`

2. **Login not working**
    - Use correct credentials from this guide
    - Clear cache: `php artisan config:clear`

3. **API returning 401**
    - Include Authorization header with Bearer token
    - Token expires after logout

---

## 🎓 Learning Outcomes

This dashboard demonstrates:

- ✅ Role-based access control
- ✅ RESTful API design
- ✅ Database relationships
- ✅ Laravel Blade templating
- ✅ Session-based authentication
- ✅ Responsive design principles
- ✅ Event-driven architecture
- ✅ Queue job processing
- ✅ Task scheduling
- ✅ File uploads (Spatie Media Library)
- ✅ Localization support
- ✅ Custom permission systems

---

**🎉 Happy Learning with MiniMedi!**
