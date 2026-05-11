---
trigger: always_on
---

# Standards de Qualité Senior et Sécurité (Laravel Backend)

## 1. Clean Code PHP
- **PSR-12**: Follow PHP coding standards
- **SRP**: Single Responsibility Principle for Controllers/Services
- **D.R.Y**: Extract repeated logic to Services/Traits
- **Naming**: Use descriptive names (camelCase variables, PascalCase Classes)

## 2. Security Best Practices
- **SQL Injection**: Use Eloquent QB, never raw SQL
- **XSS**: Escape output in Blade with {{ }} 
- **CSRF**: Use @csrf in forms
- **Mass Assignment**: Use $fillable/$guarded on models
- **Auth**: Use Laravel's auth middleware
- **Permissions**: Use Spatie policies

## 3. Performance
- **N+1 Queries**: Use eager loading (with())
- **Indexing**: Add indexes on foreign keys
- **Caching**: Use Laravel cache for expensive queries
- **Pagination**: Use paginate() for large datasets

## 4. API & Resources
- Use API Resources for transformation
- Return proper HTTP status codes
- Validate inputs with Form Requests