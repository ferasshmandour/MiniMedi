# MiniMedi API Testing Guide

## Testing with Postman or cURL

### Base URL

```
http://127.0.0.1:8000/api/v1
```

### 1. Register a New Patient

**POST** `/auth/register`

**Body:**

```json
{
    "name": "New Patient",
    "email": "newpatient@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "phone": "+1-555-0300",
    "date_of_birth": "1995-03-15",
    "blood_type": "O+",
    "allergies": "None",
    "address": "789 Pine Street"
}
```

**Response:**

```json
{
    "success": true,
    "message": "Patient registered successfully",
    "data": {
        "user": {...},
        "patient": {...},
        "token": "1|laravel_sanctum_token..."
    }
}
```

### 2. Login

**POST** `/auth/login`

**Body:**

```json
{
    "email": "patient@example.com",
    "password": "password123"
}
```

**Response:**

```json
{
    "success": true,
    "message": "Login successful",
    "data": {
        "user": {...},
        "role": "patient",
        "token": "1|laravel_sanctum_token..."
    }
}
```

### 3. Get Profile

**GET** `/auth/profile`
**Headers:** `Authorization: Bearer {token}`

**Response:**

```json
{
    "success": true,
    "data": {
        "user": {...},
        "role": "patient",
        "patient": {...}
    }
}
```

### 4. Book an Appointment

**POST** `/appointments`
**Headers:** `Authorization: Bearer {token}`

**Body:**

```json
{
    "doctor_id": 2,
    "appointment_date": "2026-02-15 10:00:00",
    "reason": "Regular checkup"
}
```

**Response:**

```json
{
    "success": true,
    "message": "Appointment booked successfully",
    "data": {
        "patient_id": 4,
        "doctor_id": 2,
        "appointment_date": "2026-02-15 10:00:00",
        "status": "pending",
        "reason": "Regular checkup",
        "created_at": "2026-02-07T21:00:00.000000Z"
    }
}
```

### 5. View Appointments

**GET** `/appointments`
**Headers:** `Authorization: Bearer {token}`

**Response:**

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "patient_id": 4,
            "doctor_id": 2,
            "appointment_date": "2026-02-15 10:00:00",
            "status": "pending",
            "reason": "Regular checkup",
            "patient": {...},
            "doctor": {...}
        }
    ],
    "count": 1
}
```

### 6. View Appointment Details

**GET** `/appointments/{id}`
**Headers:** `Authorization: Bearer {token}`

### 7. Cancel Appointment

**POST** `/appointments/{id}/cancel`
**Headers:** `Authorization: Bearer {token}`

**Response:**

```json
{
    "success": true,
    "message": "Appointment cancelled successfully",
    "data": {
        "id": 1,
        "status": "cancelled"
    }
}
```

### 8. Logout

**POST** `/auth/logout`
**Headers:** `Authorization: Bearer {token}`

**Response:**

```json
{
    "success": true,
    "message": "Logged out successfully"
}
```

## Testing with cURL Examples

### Register Patient

```bash
curl -X POST http://127.0.0.1:8000/api/v1/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test Patient",
    "email": "test@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'
```

### Login

```bash
curl -X POST http://127.0.0.1:8000/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "patient@example.com",
    "password": "password123"
  }'
```

### Get Appointments (with token)

```bash
curl -X GET http://127.0.0.1:8000/api/v1/appointments \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

### Book Appointment (with token)

```bash
curl -X POST http://127.0.0.1:8000/api/v1/appointments \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{
    "doctor_id": 2,
    "appointment_date": "2026-02-20 14:00:00",
    "reason": "Follow-up visit"
  }'
```

## Test Users

| Role    | Email                | Password    |
| ------- | -------------------- | ----------- |
| Admin   | admin@hospital.com   | password123 |
| Doctor  | doctor@hospital.com  | password123 |
| Doctor  | doctor2@hospital.com | password123 |
| Patient | patient@example.com  | password123 |
| Patient | patient2@example.com | password123 |

## Expected Behaviors

### Authorization

- All appointment endpoints require authentication
- Patients can only see their own appointments
- Doctors can only see their assigned appointments
- Only patients can book or cancel appointments

### Validation

- Email must be unique
- Appointment date must be in the future
- Doctor must exist and have 'doctor' role
- Password must be at least 8 characters

### Events & Observers

When an appointment is created:

1. `AppointmentCreated` event is fired
2. `AppointmentObserver` handles the event
3. `SendAppointmentNotification` job is queued
4. Notification is logged (check `storage/logs/laravel.log`)

### Media Upload

After creating an appointment, you can upload files:

```php
$appointment->addMedia($file)->toMediaCollection('appointment_files');
```

## Error Responses

### 401 Unauthorized

```json
{
    "success": false,
    "message": "Invalid credentials"
}
```

### 403 Forbidden

```json
{
    "success": false,
    "message": "Only patients can book appointments"
}
```

### 404 Not Found

```json
{
    "success": false,
    "message": "Appointment not found"
}
```

### 422 Validation Error

```json
{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "email": ["The email has already been taken."]
    }
}
```

## Queue Testing

### Process Queued Jobs

```bash
php artisan queue:work
```

### Check Logs for Notifications

```bash
tail -f storage/logs/laravel.log
```

## Scheduled Tasks

### Test Daily Report Manually

```bash
php artisan appointments:daily-report
```

### Schedule Frequency

- Runs daily at midnight
- Generates appointment statistics
- Logs report to `laravel.log`
