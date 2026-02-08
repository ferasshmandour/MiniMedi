# MiniMedi - Entity-Relationship Diagram (ERD)

## Overview

MiniMedi is a hospital management system with Patients, Doctors, Appointments, and Medical Notes.

## Database Schema

### 1. Users Table (Extended Authentication)

| Column            | Type                               | Description                 |
| ----------------- | ---------------------------------- | --------------------------- |
| id                | BIGINT UNSIGNED                    | Primary Key, Auto Increment |
| name              | VARCHAR(255)                       | User's full name            |
| email             | VARCHAR(255)                       | Unique email address        |
| email_verified_at | TIMESTAMP                          | Email verification time     |
| password          | VARCHAR(255)                       | Hashed password             |
| role              | ENUM('admin', 'doctor', 'patient') | User role                   |
| remember_token    | VARCHAR(100)                       | Remember token              |
| created_at        | TIMESTAMP                          | Creation timestamp          |
| updated_at        | TIMESTAMP                          | Update timestamp            |

### 2. Doctors Table (Extends User)

| Column         | Type            | Description                  |
| -------------- | --------------- | ---------------------------- |
| id             | BIGINT UNSIGNED | Primary Key (FK to users.id) |
| specialization | VARCHAR(255)    | Medical specialization       |
| license_number | VARCHAR(50)     | Medical license number       |
| department     | VARCHAR(100)    | Department name              |
| phone          | VARCHAR(20)     | Contact phone                |
| available_from | TIME            | Available from time          |
| available_to   | TIME            | Available until time         |

### 3. Patients Table (Extends User)

| Column          | Type            | Description                                   |
| --------------- | --------------- | --------------------------------------------- |
| id              | BIGINT UNSIGNED | Primary Key (FK to users.id)                  |
| phone           | VARCHAR(20)     | Contact phone                                 |
| address         | TEXT            | Patient address                               |
| date_of_birth   | DATE            | Date of birth                                 |
| blood_type      | VARCHAR(5)      | Blood type (A+, A-, B+, B-, AB+, AB-, O+, O-) |
| allergies       | TEXT            | Known allergies                               |
| medical_history | TEXT            | Medical history notes                         |

### 4. Appointments Table

| Column           | Type                                                   | Description                        |
| ---------------- | ------------------------------------------------------ | ---------------------------------- |
| id               | BIGINT UNSIGNED                                        | Primary Key, Auto Increment        |
| patient_id       | BIGINT UNSIGNED                                        | Foreign Key to users.id (patients) |
| doctor_id        | BIGINT UNSIGNED                                        | Foreign Key to users.id (doctors)  |
| appointment_date | DATETIME                                               | Scheduled appointment date/time    |
| status           | ENUM('pending', 'confirmed', 'completed', 'cancelled') | Appointment status                 |
| reason           | TEXT                                                   | Reason for appointment             |
| notes            | TEXT                                                   | Additional notes                   |
| created_at       | TIMESTAMP                                              | Creation timestamp                 |
| updated_at       | TIMESTAMP                                              | Update timestamp                   |

### 5. MedicalNotes Table

| Column         | Type            | Description                       |
| -------------- | --------------- | --------------------------------- |
| id             | BIGINT UNSIGNED | Primary Key, Auto Increment       |
| appointment_id | BIGINT UNSIGNED | Foreign Key to appointments.id    |
| doctor_id      | BIGINT UNSIGNED | Foreign Key to users.id (doctors) |
| diagnosis      | TEXT            | Doctor's diagnosis                |
| prescription   | TEXT            | Prescription details              |
| treatment_plan | TEXT            | Treatment plan                    |
| created_at     | TIMESTAMP       | Creation timestamp                |
| updated_at     | TIMESTAMP       | Update timestamp                  |

### 6. Roles Table (Role-Permission Example)

| Column      | Type            | Description                 |
| ----------- | --------------- | --------------------------- |
| id          | BIGINT UNSIGNED | Primary Key, Auto Increment |
| name        | VARCHAR(50)     | Role name (unique)          |
| description | TEXT            | Role description            |
| permissions | JSON            | Array of permission strings |
| created_at  | TIMESTAMP       | Creation timestamp          |
| updated_at  | TIMESTAMP       | Update timestamp            |

### 7. RoleUser Table (Pivot Table)

| Column     | Type            | Description                 |
| ---------- | --------------- | --------------------------- |
| id         | BIGINT UNSIGNED | Primary Key, Auto Increment |
| role_id    | BIGINT UNSIGNED | Foreign Key to roles.id     |
| user_id    | BIGINT UNSIGNED | Foreign Key to users.id     |
| created_at | TIMESTAMP       | Creation timestamp          |

## Relationships

### User Relationships

- **One-to-One (Polymorphic)**: User can have one Doctor profile OR one Patient profile
- **One-to-Many**: User can have many Appointments (as patient) OR Medical Notes (as doctor)
- **One-to-Many (Polymorphic)**: User can have many Media attachments

### Doctor Relationships

- **One-to-One**: Doctor extends User (morphOne)
- **One-to-Many**: Doctor has many Appointments
- **One-to-Many**: Doctor has many MedicalNotes

### Patient Relationships

- **One-to-One**: Patient extends User (morphOne)
- **One-to-Many**: Patient has many Appointments
- **One-to-Many**: Patient has many MedicalNotes (through appointments)

### Appointment Relationships

- **BelongsTo**: Appointment belongs to Patient (User)
- **BelongsTo**: Appointment belongs to Doctor (User)
- **HasOne**: Appointment has one MedicalNote
- **MorphMany**: Appointment has many Media attachments

### MedicalNote Relationships

- **BelongsTo**: MedicalNote belongs to Appointment
- **BelongsTo**: MedicalNote belongs to Doctor (User)

## Special Implementation Notes

1. **Morph Relations**: Use Laravel's polymorphic relationships for User profiles (Doctor/Patient) and Media attachments

2. **Localization**: All status labels and enum values should support localization (en/ar)

3. **Role-Permission**: Simple implementation with Roles table containing JSON permissions array

4. **Media Upload**: Use Spatie Media Library on Appointment and MedicalNote models

## ERD Diagram (Visual)

```
┌─────────────────────────────────────────────────────────────┐
│                        USERS                                 │
│ ┌─────────────────────────────────────────────────────────┐ │
│ │ id, name, email, password, role, timestamps            │ │
│ └─────────────────────────────────────────────────────────┘ │
│           │                         │                        │
│           │ morphOne                 │ morphOne              │
│           ▼                         ▼                        │
│ ┌─────────────────────┐    ┌─────────────────────┐           │
│ │      DOCTORS       │    │      PATIENTS       │           │
│ │ (specialization,    │    │ (phone, address,    │           │
│ │  license_number,    │    │  date_of_birth,     │           │
│ │  department, etc.)  │    │  allergies, etc.)   │           │
│ └─────────────────────┘    └─────────────────────┘           │
│           │                         │                        │
│           │ hasMany                 │ hasMany               │
│           ▼                         ▼                        │
│ ┌─────────────────────────────────────────────────────────┐ │
│ │                   APPOINTMENTS                          │ │
│ │ (patient_id, doctor_id, appointment_date, status, etc.) │ │
│ └─────────────────────────────────────────────────────────┘ │
│           │                         │                        │
│           │ hasOne                  │ hasMany               │
│           ▼                         ▼                        │
│ ┌─────────────────────┐    ┌─────────────────────┐           │
│ │    MEDICAL NOTES    │    │      MEDIA          │           │
│ │ (diagnosis,         │    │  (polymorphic:      │           │
│ │  prescription,      │    │   Appointment,      │           │
│ │  treatment_plan)   │    │   MedicalNote)      │           │
│ └─────────────────────┘    └─────────────────────┘           │
└─────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────┐
│                       ROLES                                 │
│ ┌─────────────────────────────────────────────────────────┐ │
│ │ id, name, description, permissions (JSON)              │ │
│ └─────────────────────────────────────────────────────────┘ │
│           │                                                 │
│           │ belongsToMany (via role_user pivot)            │
│           ▼                                                 │
│ ┌─────────────────────────────────────────────────────────┐ │
│ │                      USERS                               │ │
└─────────────────────────────────────────────────────────────┘
```

## Implementation Order

1. Users migration (already exists)
2. Create Doctors and Patients migrations
3. Create Appointments and MedicalNotes migrations
4. Create Roles and RoleUser migrations
5. Create Models with relationships
6. Set up database seeders
7. Build API and Web routes
8. Implement controllers and views
