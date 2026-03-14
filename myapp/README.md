# LMS - Advanced Learning Management System

A production-ready Learning Management System built with Laravel, similar to Udemy.

## Tech Stack

- **Backend:** Laravel 12
- **Frontend:** Blade + TailwindCSS + Alpine.js
- **Database:** SQLite (default) / MySQL
- **Auth:** Laravel Breeze
- **PDF:** barryvdh/laravel-dompdf

## Installation

```bash
composer install
cp .env.example .env
php artisan key:generate
```

**For MySQL** (edit `.env`):
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lms
DB_USERNAME=root
DB_PASSWORD=
```

```bash
php artisan migrate --seed
php artisan storage:link
npm install && npm run build
```

## Running the Application

```bash
php artisan serve
# Visit http://localhost:8000
```

## Default Credentials (after seeding)

| Role      | Email              | Password |
|-----------|--------------------|----------|
| Admin     | admin@lms.test     | password |
| Instructor| instructor1@lms.test | password |
| Student   | student1@lms.test  | password |

## Modules Implemented

1. **Authentication** - Laravel Breeze (register, login, forgot password, profile)
2. **Role-Based Access** - Admin, Instructor, Student with RoleMiddleware
3. **Course Management** - CRUD, thumbnails, categories, publish/draft
4. **Lesson Management** - Video URL/upload, PDF materials, ordering
5. **Enrollment** - Students enroll, progress tracking
6. **Quiz System** - Multiple choice, timed quizzes, scoring
7. **Progress Tracking** - Lesson completion, course percentage
8. **Reviews** - 1-5 star ratings with comments
9. **Certificates** - PDF generation on course completion
10. **Admin Dashboard** - User/course/category management, instructor approval
11. **Notifications** - Enrollment, new lesson, quiz result
12. **Search & Filter** - Course catalog with category/search

## Project Structure

```
app/
├── Http/Controllers/
│   ├── Admin/          # Admin panel controllers
│   ├── Instructor/     # Instructor dashboard controllers
│   └── Student/        # Student dashboard
├── Models/             # Eloquent models with relationships
├── Services/           # CourseService, EnrollmentService, CertificateService
├── Notifications/      # Database notifications
├── Policies/           # CoursePolicy
└── Http/Middleware/    # RoleMiddleware
```

## API-Ready Architecture

Controllers use Service classes for business logic, making it straightforward to add API routes later for mobile/Flutter apps.

## Screens

- **Public:** Homepage, Course Catalog, Course Details
- **Student:** Dashboard, Course Learning, Quizzes, Certificates
- **Instructor:** Dashboard, Course CRUD, Lessons, Quizzes, Enrollments
- **Admin:** Dashboard, Users, Courses, Categories
