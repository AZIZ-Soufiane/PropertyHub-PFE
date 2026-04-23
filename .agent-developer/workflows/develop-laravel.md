---
description: Workflow for Laravel backend development
---

# Workflow: Develop Laravel (`/develop-laravel`)

**Objective**: Orchestrate Laravel backend development

## Execution

### 1. Analyze Project
- Read specifications: `1.analyse-besoin/cahier-des-charges.md`
- Read content strategy: `2.organisation-contenu/content-strategy.md`
- Check existing Models, Controllers, Services, Migrations

### 2. Identify Features to Build
- Properties Management (CRUD)
- Appointments System
- Messages System
- Authentication (Laravel UI)
- Permissions (Spatie)

### 3. Execute Actions

#### Step 1: Properties
```
Check: model Property exists?
Check: PropertyController exists?
Check: PropertyService exists?
→ If missing: Action F for Properties
```

#### Step 2: Appointments
```
Check: model Appointment exists?
Check: AppointmentController exists?
→ If missing: Action F for Appointments
```

#### Step 3: Messages
```
Check: model Message exists?
Check: MessageController exists?
→ If missing: Action F for Messages
```

#### Step 4: Auth
```
Check: AuthController exists?
Check: login/register views exist?
→ If missing: Action C (Laravel UI)
```

#### Step 5: Permissions
```
Check: Spatie installed?
Check: roles configured?
→ If missing: Action D (Spatie)
```

### 4. Result
Display: "✅ Laravel development complete!"
List created files