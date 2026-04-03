<?php

namespace App\Http\Controllers;

use App\Services\PropertyHubApiService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private PropertyHubApiService $apiService)
    {
    }

    /**
     * Show login form
     */
    public function showLogin()
    {
        if (auth('api')->check()) {
            return redirect()->route('properties.index');
        }
        return view('auth.login');
    }

    /**
     * Handle login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $result = $this->apiService->login($request->email, $request->password);

        if ($result['status'] === 'success' && isset($result['token'])) {
            session(['user' => $result['data'], 'api_token' => $result['token']]);
            return redirect()->route('properties.index')->with('success', 'Welcome back!');
        }

        return back()->withErrors(['email' => $result['message'] ?? 'Invalid credentials']);
    }

    /**
     * Show register form
     */
    public function showRegister()
    {
        if (auth('api')->check()) {
            return redirect()->route('properties.index');
        }
        return view('auth.register');
    }

    /**
     * Handle registration
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:buyer,agent',
        ]);

        $result = $this->apiService->register(
            $request->name,
            $request->email,
            $request->password,
            $request->password_confirmation,
            $request->role
        );

        if ($result['status'] === 'success' && isset($result['token'])) {
            session(['user' => $result['data'], 'api_token' => $result['token']]);
            return redirect()->route('properties.index')->with('success', 'Registration successful! Welcome to PropertyHub!');
        }

        return back()->withErrors(['email' => $result['message'] ?? 'Registration failed']);
    }

    /**
     * Logout
     */
    public function logout()
    {
        session()->flush();
        return redirect()->route('properties.index')->with('success', 'Logged out successfully');
    }
}
