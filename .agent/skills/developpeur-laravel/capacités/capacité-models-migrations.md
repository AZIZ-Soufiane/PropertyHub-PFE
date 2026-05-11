# Capacité : Models et Migrations

## Description
Crée ou modifie un Model Eloquent avec sa Migration.

## Inputs
- `$NOM_MODEL` (ex: Property, Appointment, Message)
- `$CHAMPS` (array de champs)
- `$RELATIONS` (relations Eloquent)

## Processus

### 1. Créer le Model avec Migration
```bash
php artisan make:model $NOM_MODEL -m
```

### 2. Configurer la Migration
Définir les champs dans `database/migrations/xxx_create_{table}_table.php`:
```php
$table->id();
$table->string('title');
$table->text('description');
$table->decimal('price', 10, 2);
$table->foreignId('agent_id')->constrained()->onDelete('cascade');
$table->timestamps();
```

### 3. Configurer le Model
Dans `app/Models/{Model}.php`:
```php
protected $fillable = ['title', 'description', 'price', 'agent_id'];

public function agent()
{
    return $this->belongsTo(User::class, 'agent_id');
}
```

### 4. Ajouter les index
```php
$table->index('agent_id');
$table->index('created_at');
```

## Output
- Model créé dans `app/Models/`
- Migration criada dans `database/migrations/`
- Relations définies