# Develop Laravel Workflow

## Project PropertyHub
Laravel 12 application in `PropertyHub-PFE/PropertyHub/`

## Development Workflow

### 1. Read Specifications
- **Requirements**: `1.analyse-besoin/cahier-des-charges.md`
- **Content Strategy**: `2.organisation-contenu/content-strategy.md`

### 2. Analyze Current State
- Check existing Models (`app/Models/`)
- Check existing Controllers (`app/Http/Controllers/`)
- Check existing Services (`app/Services/`)
- Check existing Migrations (`database/migrations/`)
- Check Routes (`routes/web.php`)

### 3. Develop Features (Action F)

#### Properties Management
- Model: Property (exists)
- Controller: Agent\PropertyController (exists)
- Service: PropertyService (exists)

#### Appointments
- Model: Appointment (exists)
- Controller: AppointmentController (exists)
- Service: AppointmentService (exists)

#### Messages
- Model: Message (exists)
- Controller: MessageController (exists)
- Service: MessageService (exists)

#### Authentication
- Custom AuthController
- Laravel UI for views

#### Permissions (Spatie)
- Roles: admin, agent, client

### 4. Commands Reference

```bash
# Setup
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate

# Development
php artisan make:model ModelName -m
php artisan make:controller ControllerName --resource
php artisan make:service ServiceName
php artisan make:seeder SeederName

# Auth
composer require laravel/ui
php artisan ui:controllers AuthController

# Spatie
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
```