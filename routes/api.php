<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Users: Students/Teachers
//Login
Route::post('login', [UserController::class, 'login']);
Route::get('login', [UserController::class, 'login'])->name('login');
//Register
Route::post('register', [UserController::class, 'register']);
//Logout
Route::post('logout', [UserController::class, 'logout']);

//User Auth middleware
Route::middleware('auth:api')->group(function () {
    //Students
    Route::post('create_student', [StudentController::class, 'store']);
    Route::get('edit_student/{user_id}', [StudentController::class, 'edit']);
    Route::put('update_student', [StudentController::class, 'update']);

    //Teachers
    Route::post('create_teacher', [TeacherController::class, 'store']);
    Route::get('edit_teacher/{user_id}', [TeacherController::class, 'edit']);
    Route::put('update_teacher', [TeacherController::class, 'update']);
});

// Admin middleware
Route::middleware(['auth:api', 'isAdmin'])->group(function () {
    // Delete User
    Route::put('delete_user/{user_id}', [AdminController::class, 'delete']);
    // Get Users for approval
    Route::get('get_users_for_approval/{user_type}', [
        AdminController::class,
        'get_users_for_approval',
    ]);
    // Approve User
    Route::put('approve_user/{user_id}', [
        AdminController::class,
        'approve_user',
    ]);
    // Approve All Users
    Route::put('approve_all_users', [
        AdminController::class,
        'approve_all_users',
    ]);
    // Assign Teacher
    Route::put('assign_teacher', [AdminController::class, 'assign_teacher']);

    // Search
    Route::get('get_users/{user_type}', [AdminController::class, 'get_users']);
    Route::get('get_user/{user_id}', [AdminController::class, 'get_user']);
    //Search
    // Route::get('search/{name}', [SearchController::class, 'Search']);
});
