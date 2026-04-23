---
trigger: always_on
---

# Technical Stack (Laravel Backend)

## 1. Backend (Laravel 12)
- **PHP**: ^8.2
- **Framework**: Laravel 12
- **Auth**: Laravel UI (Breeze/Jetstream concepts adapted)
- **Permissions**: Spatie laravel-permission
- **Database**: MySQL/SQLite (see .env)
- **ORM**: Eloquent

## 2. Architecture
- **MVC Pattern**: Models, Views (Blade), Controllers
- **Services**: Business logic in App/Services/
- **Resources**: API Transformers in App/Http/Resources/
- **Requests**: Form Requests for validation in App/Http/Requests/

## 3. Conventions
- RESTful controllers
- Resource-based routing
- Policy-based authorization
- Service classes for complex business logic

## 4. Frontend (Minimal - handled by design agent)
- Blade templates
- Laravel Mix / Vite for assets
- Tailwind CSS (via Laravel)