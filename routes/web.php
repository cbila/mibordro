<?php

use App\Http\Controllers\ActivitiesController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\SGKController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserExportController;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome');
});

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });
// Route::get('/policy', function () {
//     return Inertia::render('Policy');
// });




Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/setLang/{locale}', function ($locale) {
    Session::put('locale', $locale);
    return back();
})->name('setlang');




Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', [DashboardController::class, 'show'])->name('dashboard');

    Route::resource('/users', UserController::class);
    Route::patch('/users/{user}/restore', [UserController::class, 'restore'])->name('users.restore');
    Route::delete('/users/{user}/forceDelete', [UserController::class, 'forceDelete'])->name('users.forceDelete');
    Route::get('/users/{user}/activities', [ActivitiesController::class, 'activities'])->name('users.activities');

    Route::get('/user/{user}/documents', [DocumentsController::class, 'index'])->name('documents.index');
    Route::get('/user/{user}/documents/{document}/view', [DocumentsController::class, 'view'])->name('documents.view');
    Route::patch('/documents/{document}', [DocumentsController::class, 'update'])->name('documents.update');
    Route::post('/user/{user}/documents', [DocumentsController::class, 'store'])->name('documents.store');
    Route::get('/user/{user}/documents/{document}', [DocumentsController::class, 'download'])->name('documents.download');
    Route::delete('/documents/{document}', [DocumentsController::class, 'destroy'])->name('documents.destroy');

    Route::get('/export/user', [UserExportController::class, 'create'])->name('user.export');

    Route::resource('/company', CompanyController::class);
    Route::patch('/company/{company}/restore', [CompanyController::class, 'restore'])->name('company.restore');
    Route::delete('/company/{company}/forceDelete', [CompanyController::class, 'forceDelete'])->name('company.forceDelete');



    Route::resource('/sgk', SGKController::class);
    Route::patch('/sgk/{sgk}/restore', [SGKController::class, 'restore'])->name('sgk.restore');
    Route::delete('/sgk/{sgk}/forceDelete', [SGKController::class, 'forceDelete'])->name('sgk.forceDelete');

    Route::resource('/role', RoleController::class)->except('create', 'show', 'edit');

    Route::resource('/category', CategoryController::class);
    Route::patch('/category/{category}/restore', [CategoryController::class, 'restore'])->name('category.restore');
    Route::delete('/category/{category}/forceDelete', [CategoryController::class, 'forceDelete'])->name('category.forceDelete');



    Route::resource('/role', RoleController::class)->except('create', 'show', 'edit');
    // Route::post('/role/destroy-bulk', [RoleController::class, 'destroyBulk'])->name('role.destroy-bulk');

    Route::resource('/permission', PermissionController::class)->except('create', 'show', 'edit');
    // Route::post('/permission/destroy-bulk', [PermissionController::class, 'destroyBulk'])->name('permission.destroy-bulk');

    Route::resource('/activities', ActivitiesController::class);

    Route::post('/mail-send', [MailController::class, 'store'])->name('mail.store');




    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});


require __DIR__.'/auth.php';
