<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BoutiqueController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CommandesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProduitsController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AccountValidation;
use App\Http\Middleware\CheckAdmin;
use App\Http\Middleware\LicenceCheck;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
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

Route::redirect('account/login', 'login')->name('account.login');
Route::get('dologout', [LoginController::class, 'doLogout']);
Route::get('paiement', [BoutiqueController::class, 'paiement'])->name('paiement');
Route::post('update/pwd', [ForgotPasswordController::class, 'ResetPassword'])->name('update.password');
Route::post('send/reserPassword/link', [ForgotPasswordController::class, 'sendResetPasswordLink'])->name('send.reset.link');
Route::get('resetPassword/infos/{_token}/{email}/{date}', [ForgotPasswordController::class, 'ResetPasswordInfo'])->name('reset.password.data');
Route::view('/privacy-term', 'privacy-term')->name('privacy.term');

Route::get('home', function () {
    return redirect()->route('home');
});

//Route::get('/', function () {
//    return redirect()->route('welcome');
//});
Route::redirect('/', 'welcome');
Route::get('welcome', [HomeController::class, 'home'])->name('welcome');
Route::get('site/home', [HomeController::class, 'site'])->name('site.home');
Route::get('site/shop', [BoutiqueController::class, 'boutique'])->name('site.boutique');
Route::get('site/showCard', [BoutiqueController::class, 'card'])->name('site.card');
Route::get('site/addToCard/{id}', [BoutiqueController::class, 'addToCard'])->name('site.add.tocard');
Route::get('site/detail/{id}', [BoutiqueController::class, 'detailProduit'])->name('site.detail');
Route::get('site/boutique/categorie/{id}', [BoutiqueController::class, 'categorie'])->name('site.categories');
Route::get('site/romoveFromCard/{id}', [BoutiqueController::class, 'removeFromCard'])->name('site.removeFromCard');
Route::get('site/clearCard', [BoutiqueController::class, 'removeAllCard'])->name('site.clearCard');
Route::get('site/checkout/page', [BoutiqueController::class, 'showCheckout'])->name('site.checkout.page');
Route::post('site/checkout', [BoutiqueController::class, 'removeAllCard'])->name('site.checkout');
Route::post('commande/store', [CommandesController::class, 'store'])->name('commande.store');

Auth::routes();



Route::prefix('dashboard')->group(function () {

    Route::group(['middleware' => 'auth'], function () {

        //Route for user only for active user with valid licence
        Route::middleware([AccountValidation::class, LicenceCheck::class])->group(function () {
            Route::get('home', [HomeController::class, 'index'])->name('home');

            //Route for for profile account
            Route::get('user/profile', [UserController::class, 'showProfile'])->name('user.profile');
            Route::post('user/updateInfos', [UserController::class, 'updateInfos'])->name('user.edit.infos');
            Route::post('user/updatepassword', [UserController::class, 'updatePassword'])->name('user.edit.password');
            Route::post('user/profile/image', [UserController::class, 'UpdateImage'])->name('user.profil.image');

            Route::resource('categories', CategoriesController::class);
            Route::post('categorie/delete', [CategoriesController::class, 'delete'])->name('categories.delete');
            Route::resource('produits', ProduitsController::class);
            Route::get('product/edit/{id}', [ProduitsController::class, 'edit'])->name('product.edit');
            Route::post('product/update', [ProduitsController::class, 'update'])->name('product.update');
            Route::post('produit/delete', [ProduitsController::class, 'delete'])->name('produit.delete');
            Route::resource('commandes', CommandesController::class);
            Route::post('commande/delete', [CommandesController::class, 'delete'])->name('commande.delete');
            Route::get('commande/encours/{id}', [CommandesController::class, 'encours'])->name('commande.encours');
            Route::get('commande/traite/{id}', [CommandesController::class, 'traite'])->name('commande.traite');
            Route::get('commande/client', [CommandesController::class, 'client'])->name('commande.client');
            //Route for admin prefix with admin depend on  middleware to allow only admin
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

});
Route::get('clear', function () {
    Artisan::call('route:clear');
    Artisan::call('route:cache');
    Artisan::call('optimize --force');
    Artisan::call('optimize');
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    return "Cleared!";
});
Route::get('clear/route', function () {
    Artisan::call('route:clear');
    Artisan::call('route:cache');
    return "Route cleared!";
});
Route::get('up', function () {
    Artisan::call('up');
    return redirect('/login');
});
Route::get('down', function () {
    Artisan::call('down');
    return "Application is now down!";
});
