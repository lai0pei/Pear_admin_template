<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Modules\BackEnd\Http\Controllers\Foundation\Index\IndexController;
use Modules\BackEnd\Http\Controllers\Foundation\Admin\OnlineAdminController;
use Modules\BackEnd\Http\Controllers\Foundation\Admin\AdminController;
use Modules\BackEnd\Http\Controllers\Foundation\Role\RoleController;
use Modules\BackEnd\Http\Controllers\Foundation\Authendication\LoginController;
use Modules\BackEnd\Http\Controllers\Foundation\Authendication\LogoutController;
use Modules\BackEnd\Http\Controllers\Foundation\Authendication\AuthController;
use Modules\BackEnd\Http\Controllers\Foundation\Log\LogController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$secure_url = config('common.backend_sufix');

Route::prefix($secure_url)->group(function () {
    Route::get('/login', function (Request $request) {
        return (is_login()) ? redirect()->route('home') : (new LoginController($request))->view();
    })->name('loginView');
    
    Route::middleware(['backend_csrf'])->post('/login', [LoginController::class, 'loginAction'])->name('loginAction');
});


Route::middleware(['backend_csrf','backend_auth', 'backend_auth.session'])->prefix($secure_url)->group(function () {
    
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
    Route::get('/', [IndexController::class, 'view'])->name('home');
    
    Route::prefix('ui')->group(function () {
        Route::get('/getUiMenu', [IndexController::class, 'getUiMenu'])->name('getUiMenu');
        Route::get('/getUiConfig', [IndexController::class, 'getUiConfig'])->name('getUiConfig');
        Route::get('/getUiMessage', [IndexController::class, 'getUiMessage'])->name('getUiMessage');
    });

    Route::prefix('admin')->group(function () {
        Route::get('/view', [AdminController::class, 'view'])->name('admin_management');
        Route::get('/list', [AdminController::class, 'list'])->name('admin_list');
        Route::get('/addView', [AdminController::class, 'add_view'])->name('admin_addView');
        Route::get('/updateView/{id?}', [AdminController::class, 'update_view'])->name('admin_updateView');

        Route::post('/add', [AdminController::class, 'add'])->name('admin_add');
        Route::post('/update', [AdminController::class, 'update'])->name('admin_update');
        Route::post('/delete', [AdminController::class, 'delete'])->name('admin_delete');
        Route::post('/change_status', [AdminController::class, 'changeStatus'])->name('admin_change_status');
    });

    Route::prefix('role')->group(function () {
        Route::get('/view', [RoleController::class, 'view'])->name('role_management');
        Route::get('/list', [RoleController::class, 'list'])->name('role_list');
        Route::get('/addView', [RoleController::class, 'add_view'])->name('role_addView');
        Route::get('/updateView/{id?}', [RoleController::class, 'update_view'])->name('role_updateView');

        Route::post('/add', [RoleController::class, 'add'])->name('role_add');
        Route::post('/update', [RoleController::class, 'update'])->name('role_update');
        Route::post('/delete', [RoleController::class, 'delete'])->name('role_delete');
        Route::post('/change_status', [RoleController::class, 'changeStatus'])->name('role_change_status');
    });

    Route::prefix('online')->group(function () {
        Route::get('/view', [OnlineAdminController::class, 'view'])->name('online_admin');
        Route::get('/list', [OnlineAdminController::class, 'list'])->name('online_list');
        Route::get('/updateView/{id?}', [OnlineAdminController::class, 'update_view'])->name('online_updateView');

        Route::post('/force_offline', [OnlineAdminController::class, 'forceOffline'])->name('admin_force_offline');
    });

    Route::prefix('auth')->group(function () {
        Route::get('/view', [AuthController::class, 'view'])->name('auth_management');
        Route::get('/list', [AuthController::class, 'list'])->name('auth_list');
        Route::get('/updateView/{id?}', [AuthController::class, 'update_view'])->name('auth_updateView');

        Route::post('/update', [AuthController::class, 'update'])->name('auth_update');
        Route::post('/change_status', [AuthController::class, 'changeStatus'])->name('auth_change_status');
    });

    Route::prefix('log')->group(function () {
        Route::get('/view', [LogController::class, 'view'])->name('log_management');
        Route::get('/list', [LogController::class, 'list'])->name('log_list');
        Route::get('/updateView/{id?}', [LogController::class, 'update_view'])->name('log_updateView');

    });

    
});
