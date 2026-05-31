<?php

use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

// Temporary admin setup route — remove after use
Route::get('/setup-admin', function () {
    \Illuminate\Support\Facades\DB::table('users')->updateOrInsert(
        ['email' => 'admin@taskflow.com'],
        [
            'name'       => 'Administrator',
            'email'      => 'admin@taskflow.com',
            'password'   => bcrypt('Admin@1234'),
            'role'       => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]
    );
    return 'Admin account created. You can now log in with admin@taskflow.com / Admin@1234';
});

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('tasks.index')
        : redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Tasks
    Route::resource('tasks', TaskController::class);
    Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.status');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');

    // Admin
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', AdminUserController::class);
    });
});
