# Capacité: Models & Migrations

## Description
Create or modify Eloquent Model with Migration.

## Process

### 1. Create Model
```bash
php artisan make:model ModelName -m
```

### 2. Configure Migration
```php
$table->id();
$table->string('title');
$table->text('description');
$table->decimal('price', 10, 2);
$table->foreignId('agent_id')->constrained()->onDelete('cascade');
$table->timestamps();
```

### 3. Configure Model
```php
protected $fillable = ['title', 'description', 'price', 'agent_id'];

public function agent()
{
    return $this->belongsTo(User::class, 'agent_id');
}
```

### 4. Add Indexes
```php
$table->index('agent_id');
```

## Output
- Model in app/Models/
- Migration in database/migrations/