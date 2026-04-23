# Capacité: Auth (Laravel UI) & Permissions (Spatie)

## Description
Configure Laravel UI authentication and Spatie permissions.

## Process

### 1. Install Laravel UI
```bash
composer require laravel/ui
```

### 2. Create Auth Controller
Create `app/Http/Controllers/AuthController.php`:
```php
<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
```

### 3. Create Login/Register Views
Simple Blade in `resources/views/auth/`:
- login.blade.php
- register.blade.php

### 4. Install Spatie
```bash
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
```

### 5. Configure Roles Migration
Add roles to users table or use Spatie tables.

### 6. Use Middleware
```php
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Admin routes
});
```

## Output
- Laravel UI auth
- Spatie permissions
- Role middleware