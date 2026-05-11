# Stack Technique de Référence - Laravel

## Backend
- **Framework**: Laravel 12
- **PHP**: ^8.2
- **Auth**: Laravel UI (Breeze-style)
- **Permissions**: Spatie laravel-permission
- **ORM**: Eloquent

## Architecture MVC
- **Models**: `app/Models/`
- **Views**: `app/resources/views/` (Blade)
- **Controllers**: `app/Http/Controllers/`
- **Migrations**: `database/migrations/`

## Services & Patterns
- **Services**: `app/Services/` (business logic)
- **Resources**: `app/Http/Resources/` (API transformation)
- **Requests**: `app/Http/Requests/` (validation)
- **Policies**: `app/Policies/` (authorization)

## Interdictions Techniques

- ❌ Pas de requêtes SQL brutes (utiliser Eloquent)
- ❌ Pas de code non sécurisé (écarter entrées utilisateur)
- ❌ Pas de logique Métier dans les Controllers (utiliser Services)
- ❌ Pas d'API Resource si pas d'API

## Commandes Utiles

```bash
# Setup
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate

# Development
php artisan serve
php artisan make:model
php artisan make:controller
php artisan make:migration
php artisan make:seeder

# Permissions Spatie
php artisan make:migration create_permissions_tables
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
```