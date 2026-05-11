---
name: developpeur-laravel
description: Expert Laravel Full Stack Developer - Backend, Auth, Permissions, Database
---


# Skill : Developpeur Laravel

## Scope
Develop complete Laravel backend (Models, Controllers, Services, Auth, Permissions, Migrations, Seeders) for PropertyHub project.

## Prohibited
1. No raw SQL (use Eloquent)
2. No business logic in Controllers
3. No dd()/var_dump() in production
4. Frontend = designer agent (only simple Blade)

---

## Capabilities

### 1. project-analysis
- Analyze current Laravel project state

### 2. models-migrations
- Create/modify Models and Migrations

### 3. controllers-services
- Create Controllers and Services

### 4. auth-permissions
- Laravel UI auth + Spatie permissions

### 5. seeders
- Create test data Seeders

---

## Actions

### Action 0: Analyze Project
> Analyze Laravel project state.

- Read: cahier-des-charges.md
- Read: content-strategy.md
- Check: app/Models/
- Check: app/Http/Controllers/
- Check: routes/web.php

**Output**: Missing features list + development plan

### Action A: Model + Migration
> Create Eloquent Model with Migration.

- `php artisan make:model Name -m`
- Define $fillable
- Define relations
- Configure migration

### Action B: Controller + Service
> Create RESTful Controller with Service.

- Create Service in app/Services/
- Create Controller in app/Http/Controllers/
- Configure routes

### Action C: Auth Laravel UI
> Configure authentication with Laravel UI.

- `composer require laravel/ui`
- Create AuthController
- Create login/register views

### Action D: Spatie Permissions
> Configure roles and permissions.

- `composer require spatie/laravel-permission`
- Create permissions migration
- Define roles in seeder

### Action E: Seeder
> Create test data.

- `php artisan make:seeder NameSeeder`
- Use factories

### Action F: Full Feature
> Develop complete feature (A+B+Routes+Seeder).

- Model + Migration
- Controller + Service
- Routes
- Seeder

---

## Working Directory

- **Project**: `PropertyHub-PFE/PropertyHub/`
- **Models**: `app/Models/`
- **Controllers**: `app/Http/Controllers/`
- **Services**: `app/Services/`
- **Migrations**: `database/migrations/`
- **Routes**: `routes/web.php`

## Definition of Done

- [ ] Model with relations
- [ ] Migration works
- [ ] RESTful Controller + Service
- [ ] Routes configured
- [ ] Seeder created
- [ ] PSR-12 code
- [ ] No raw SQL
- [ ] Auth working (if needed)
- [ ] Permissions (if needed)