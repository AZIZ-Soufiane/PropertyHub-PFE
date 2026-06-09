<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AdminDashboardService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct(
        private UserService $userService,
        private AdminDashboardService $adminDashboard,
    ) {}

    public function dashboard()
    {
        $stats = $this->adminDashboard->getStats();
        $users = $this->userService->getUsers([], 10);

        return view('admin.dashboard', compact('stats', 'users'));
    }

    public function index(Request $request)
    {
        $users = $this->userService->getUsers($request->only(['role', 'search']));
        return view('admin.users.index', compact('users'));
    }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:users,email',
            'password'       => 'required|min:8|confirmed',
            'role'           => 'required|in:admin,agent',
            'license_number' => 'nullable|string|max:100',
        ]);

        try {
            $this->userService->createUser($validated);
        } catch (\Exception $e) {
            return back()->withErrors(['email' => $e->getMessage()])->withInput();
        }

        return redirect()->route('admin.users.index')->with('success', 'User created successfully');
    }

    public function show(User $user)
    {
        return redirect()->route('admin.users.index');
    }



    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:users,email,' . $user->id,
            'password'       => 'nullable|min:8|confirmed',
            'role'           => 'required|in:admin,agent',
            'license_number' => 'nullable|string|max:100',
        ]);

        try {
            $this->userService->updateUser($user->id, $validated);
        } catch (\Exception $e) {
            return back()->withErrors(['email' => $e->getMessage()])->withInput();
        }

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        try {
            $this->userService->deleteUser($user->id, Auth::id());
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('admin.users.index')->with('success', 'User deleted');
    }
}
