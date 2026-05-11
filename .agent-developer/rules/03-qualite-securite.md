---
trigger: always_on
---

# Quality & Security Standards

## 1. Clean Code PHP
- **PSR-12**: PHP coding standards
- **SRP**: Single Responsibility Principle
- **DRY**: Extract to Services/Traits
- **Naming**: camelCase variables, PascalCase Classes

## 2. Security
- **SQL Injection**: Use Eloquent only
- **XSS**: {{ }} in Blade
- **CSRF**: @csrf in forms
- **Mass Assignment**: $fillable/$guarded
- **Auth**: Laravel auth middleware
- **Permissions**: Spatie policies

## 3. Performance
- **N+1**: Use eager loading with()
- **Indexes**: Add on foreign keys
- **Pagination**: paginate() for large datasets

## 4. API
- HTTP status codes
- Form Requests for validation