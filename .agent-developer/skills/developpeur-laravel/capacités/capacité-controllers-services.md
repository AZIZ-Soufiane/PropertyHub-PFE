# Capacité: Controllers & Services

## Description
Create RESTful Controller with Service.

## Process

### 1. Create Service
`app/Services/ModelService.php`:
```php
<?php
namespace App\Services;

use App\Models\Model;

class ModelService
{
    public function getAll()
    {
        return Model::all();
    }

    public function getById(int $id): ?Model
    {
        return Model::findOrFail($id);
    }

    public function create(array $data): Model
    {
        return Model::create($data);
    }

    public function update(int $id, array $data): Model
    {
        $model = Model::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): void
    {
        Model::destroy($id);
    }
}
```

### 2. Create Controller
`app/Http/Controllers/ModelController.php`:
```php
<?php
namespace App\Http\Controllers;

use App\Services\ModelService;
use Illuminate\Http\Request;

class ModelController extends Controller
{
    public function __construct(private ModelService $service) {}

    public function index()
    {
        return view('model.index', ['models' => $this->service->getAll()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([/* rules */]);
        $this->service->create($data);
        return redirect()->route('model.index');
    }

    public function destroy(int $id)
    {
        $this->service->delete($id);
        return redirect()->route('model.index');
    }
}
```

### 3. Configure Routes
`routes/web.php`:
```php
Route::resource('models', ModelController::class);
```

## Output
- Service in app/Services/
- Controller in app/Http/Controllers/
- Routes configured