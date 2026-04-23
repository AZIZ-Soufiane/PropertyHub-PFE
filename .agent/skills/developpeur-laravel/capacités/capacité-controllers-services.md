# Capacité : Controllers et Services

## Description
Crée un Controller RESTful avec son Service.

## Inputs
- `$NOM_MODELE` (ex: Property)
- `$METHODES` (index, show, create, store, edit, update, destroy)

## Processus

### 1. Créer le Service
Dans `app/Services/{Model}Service.php`:
```php
<?php

namespace App\Services;

use App\Models\{Model};
use Illuminate\Support\Collection;

class {Model}Service
{
    public function getAll(): Collection
    {
        return {Model}::all();
    }

    public function getById(int $id): ?{Model}
    {
        return {Model}::findOrFail($id);
    }

    public function create(array $data): {Model}
    {
        return {Model}::create($data);
    }

    public function update(int $id, array $data): {Model}
    {
        $model = {Model}::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): void
    {
        {Model}::destroy($id);
    }
}
```

### 2. Créer le Controller
Dans `app/Http/Controllers/{Model}Controller.php`:
```php
<?php

namespace App\Http\Controllers;

use App\Services\{Model}Service;
use Illuminate\Http\Request;

class {Model}Controller extends Controller
{
    public function __construct(
        private {Model}Service $service
    ) {}

    public function index()
    {
        return view('{model}.index', [
            '{models}' => $this->service->getAll()
        ]);
    }

    public function show(int $id)
    {
        return view('{model}.show', [
            '{model}' => $this->service->getById($id)
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([/** rules **/]);
        $this->service->create($data);
        return redirect()->route('{model}.index');
    }

    public function destroy(int $id)
    {
        $this->service->delete($id);
        return redirect()->route('{model}.index');
    }
}
```

### 3. Configurer les Routes
Dans `routes/web.php`:
```php
Route::resource('{models}', {Model}Controller::class);
```

## Output
- Service créé dans `app/Services/`
- Controller créé dans `app/Http/Controllers/`
- Routes configurées