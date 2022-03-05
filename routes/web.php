<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\GestionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AccountValidation;
use App\Http\Middleware\CheckAdmin;
use Illuminate\Support\Facades\Route;

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

Route::redirect('/', 'login');
Route::get('dologout', [LoginController::class, 'doLogout']);
Auth::routes();


//Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/text', [HomeController::class, 'text'])->name('text');

//Route::get('dashboard/validate/{id}', [RegisterController::class, 'validateAcount'])->name('account.validate');
Route::get('/home', function () {
    return redirect()->route('home');
});
Route::prefix('dashboard')->group(function () {

    Route::get('/', [HomeController::class, 'index']);

    Route::group(['middleware' => 'auth'], function () {

        Route::middleware([AccountValidation::class])->group(function () {
            Route::get('home', [HomeController::class, 'index'])->name('home');

            Route::get('user/profile', [UserController::class, 'showProfile'])->name('user.profile');
            Route::post('user/updateInfos', [UserController::class, 'updateInfos'])->name('user.edit.infos');
            Route::post('user/updatepassword', [UserController::class, 'updatePassword'])->name('user.edit.password');
            Route::post('user/profile/image', [UserController::class, 'UpdateImage'])->name('user.profil.image');

            Route::get('gestion/charges', [GestionController::class, 'charge'])->name('gestion.index');
            Route::post('gestion/charges/add', [GestionController::class, 'storeCharge'])->name('gestion.charge.add');
            Route::post('gestion/charges/delete', [GestionController::class, 'deleteCharge'])->name('gestion.charge.delete');

            Route::get('gestion/tasks', [UserController::class, 'UpdateImage'])->name('gestion.tache');
            Route::post('gestion/tasks/add', [UserController::class, 'UpdateImage'])->name('gestion.taches.add');
            Route::post('gestion/tasks/edit', [UserController::class, 'UpdateImage'])->name('gestion.taches.edit');
            Route::post('gestion/tasks/delete', [UserController::class, 'UpdateImage'])->name('gestion.taches.delete');
            Route::post('gestion/calendar', [UserController::class, 'UpdateImage'])->name('gestion.calendrier');
        });



        Route::prefix('admin')->group(function () {
            Route::middleware([CheckAdmin::class])->group(function () {

               // routes pour les compte utilisateurs
            Route::get('user/all', [UserController::class, 'index'])->name('user.all');
            Route::view('user/new', 'user.add')->name('user.add');
            Route::post('user/new/store', [UserController::class, 'storeUser'])->name('user.add.store');
            Route::get('user/edit/{id}', [UserController::class, 'editUser'])->name('user.edit');
            Route::post('user/edit/store', [UserController::class, 'updateUser'])->name('user.edit.store');
            Route::post('user/delete', [UserController::class, 'deleteUser'])->name('user.delete');
            Route::get('user/activate/{id}', [UserController::class, 'activate'])->name('activate_compte');
            Route::get('user/block/{id}', [UserController::class, 'block'])->name('block_compte');
            });
        });
    });

});
