# Capacité: Seeders

## Description
Create test data Seeders.

## Process

### 1. Create Seeder
```bash
php artisan make:seeder ModelNameSeeder
```

### 2. Configure Seeder
```php
<?php
namespace Database\Seeders;

use App\Models\ModelName;
use Illuminate\Database\Seeder;

class ModelNameSeeder extends Seeder
{
    public function run()
    {
        ModelName::factory()->count(10)->create();
    }
}
```

### 3. Call in DatabaseSeeder
```php
public function run()
{
    $this->call([
        ModelNameSeeder::class,
    ]);
}
```

## Output
- Seeder in database/seeders/
- Test data available