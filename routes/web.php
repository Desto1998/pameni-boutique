<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\DevisController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\FournisserController;
use App\Http\Controllers\GestionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\RapportController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AccountValidation;
use App\Http\Middleware\CheckAdmin;
use App\Models\Fournisseurs;
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

        //Route for user only for active user
        Route::middleware([AccountValidation::class])->group(function () {
            Route::get('home', [HomeController::class, 'index'])->name('home');

            //Route for for profile account
            Route::get('user/profile', [UserController::class, 'showProfile'])->name('user.profile');
            Route::post('user/updateInfos', [UserController::class, 'updateInfos'])->name('user.edit.infos');
            Route::post('user/updatepassword', [UserController::class, 'updatePassword'])->name('user.edit.password');
            Route::post('user/profile/image', [UserController::class, 'UpdateImage'])->name('user.profil.image');

            // Route for charges
            Route::get('gestion/charges', [GestionController::class, 'charge'])->name('gestion.index');
            Route::get('gestion/charges/load', [GestionController::class, 'loadCharges'])->name('gestion.load.charge');
            Route::post('gestion/charges/add', [GestionController::class, 'storeCharge'])->name('gestion.charge.add');
            Route::post('gestion/charges/delete', [GestionController::class, 'deleteCharge'])->name('gestion.charge.delete');

            // Route for taches
            Route::get('gestion/tasks', [GestionController::class, 'taches'])->name('gestion.tache');
            Route::get('gestion/tasks/load', [GestionController::class, 'loadTaches'])->name('gestion.load.tache');
            Route::post('gestion/tasks/add', [GestionController::class, 'storeTask'])->name('gestion.taches.add');
            Route::post('gestion/tasks/delete', [GestionController::class, 'deleteTache'])->name('gestion.taches.delete');

            Route::post('gestion/calendar', [UserController::class, 'UpdateImage'])->name('gestion.calendrier');

            //Route for rapport
            Route::get('rapport/charge', [RapportController::class, 'showChargeForm'])->name('rapport.charge');
            Route::get('rapport/charge/print', [RapportController::class, 'printCharge'])->name('rapport.charge.print');

            //Route for categorie
            Route::get('categorie/index',[CategorieController::class,'listCategories'])->name('categorie.all');
            Route::get('categorie/load',[CategorieController::class,'loadCategorie'])->name('categorie.load');
            Route::post('categorie/store',[CategorieController::class,'storeCategorie'])->name('categorie.store');
            Route::post('categorie/delete',[CategorieController::class,'deleteCategore'])->name('categorie.delete');

            //Routes for produit
            Route::get('product/index',[ProduitController::class,'listproduct'])->name('produit.all');
            Route::get('product/list',[ProduitController::class,'loadProducts'])->name('produit.load');
            Route::post('product/store',[ProduitController::class,'storeProduct'])->name('produit.store');
            Route::post('product/update',[ProduitController::class,'updateProduct'])->name('produit.update');
            Route::post('product/delete',[ProduitController::class,'deleteProduct'])->name('produit.delete');

            //Routes for client
            Route::get('client/index',[ClientController::class,'index'])->name('client.all');
            Route::get('client/load',[ClientController::class,'loadClients'])->name('client.load');
            Route::post('client/store',[ClientController::class,'store'])->name('client.store');
            Route::post('client/update',[ClientController::class,'update'])->name('client.update');
            Route::post('client/delete',[ClientController::class,'delete'])->name('client.delete');
            Route::get('client/edit/{id}',[ClientController::class,'showEditForm'])->name('client.edit');
            Route::get('client/details/{id}',[ClientController::class,'view'])->name('client.view');

            //Routes for fournisseur
            Route::get('fournisseur/index',[FournisserController::class,'index'])->name('fournisseur.all');
            Route::get('fournisseur/load',[FournisserController::class,'loadFournisseur'])->name('fournisseur.load');
            Route::post('fournisseur/store',[FournisserController::class,'store'])->name('fournisseur.store');
            Route::post('fournisseur/update',[FournisserController::class,'update'])->name('fournisseur.update');
            Route::get('fournisseur/edit/{id}',[FournisserController::class,'showEditForm'])->name('fournisseur.edit');
            Route::post('fournisseur/delete',[FournisserController::class,'delete'])->name('fournisseur.delete');
            Route::get('fournisseur/details/{id}',[FournisserController::class,'view'])->name('fournisseur.view');

            //Route for devis
            Route::get('devis/index',[DevisController::class,'index'])->name('devis.all');
            Route::get('devis/load',[DevisController::class,'loadDevis'])->name('devis.load');
            Route::get('devis/add',[DevisController::class,'showAddForm'])->name('devis.add');
            Route::post('devis/store',[DevisController::class,'store'])->name('devis.store');
            Route::get('devis/edit/{id}',[DevisController::class,'showEditForm'])->name('devis.edit');
            Route::post('devis/edit/store',[DevisController::class,'edit'])->name('devis.edit.store');
            Route::get('devis/details/{id}',[DevisController::class,'viewDetail'])->name('devis.view');

            Route::post('devis/valider',[DevisController::class,'validerDevis'])->name('devis.valider');
            Route::post('devis/bloquer',[DevisController::class,'bloquerDevis'])->name('devis.bloquer');

            Route::post('devis/makefacture',[DevisController::class,'makeFacture'])->name('devis.makefacture');
            Route::get('devis/print/{id}',[DevisController::class,'printDevis'])->name('devis.print');

            Route::post('devis/remove/produit',[DevisController::class,'removeProduit'])->name('devis.remove.produit');
            Route::post('devis/remove/complement',[DevisController::class,'removeComplement'])->name('devis.remove.comp');
            Route::post('devis/delete',[DevisController::class,'delete'])->name('devis.delete');

            //Route for factures
            Route::get('factures/index',[FactureController::class,'index'])->name('factures.all');
            Route::get('factures/load',[FactureController::class,'loadFactures'])->name('factures.load');
            Route::get('factures/add',[FactureController::class,'showAddForm'])->name('factures.add');
            Route::post('factures/store',[FactureController::class,'store'])->name('factures.store');
            Route::get('factures/edit/{id}',[FactureController::class,'showEditForm'])->name('factures.edit');
            Route::post('factures/edit/store',[FactureController::class,'edit'])->name('factures.edit.store');
            Route::get('factures/details/{id}',[FactureController::class,'viewDetail'])->name('factures.view');
            Route::post('factures/delete',[FactureController::class,'delete'])->name('factures.delete');
            Route::post('factures/valider',[FactureController::class,'validerFactures'])->name('factures.valider');
            Route::post('factures/bloquer',[FactureController::class,'bloquerFactures'])->name('factures.bloquer');

            Route::get('factures/print/{id}',[FactureController::class,'printFactures'])->name('factures.print');


            Route::post('factures/paiement/store',[FactureController::class,'addPaiement'])->name('factures.paiement.store');
            Route::post('factures/paiement/delete',[FactureController::class,'deletePaiement'])->name('factures.paiement.delete');
            Route::post('factures/paiement/update',[PaiementController::class,'updatePaiement'])->name('factures.paiement.update');

            //Route for commandes
            Route::get('commandes/index',[CommandeController::class,'index'])->name('commandes.all');
            Route::get('commandes/add',[CommandeController::class,'showAddForm'])->name('commandes.add');
            Route::post('commandes/store',[CommandeController::class,'store'])->name('commandes.store');
            Route::get('commandes/edit/{id}',[CommandeController::class,'showEditForm'])->name('commandes.edit');
            Route::post('commandes/edit/store',[CommandeController::class,'edit'])->name('commandes.edit.store');
            Route::post('commandes/delete',[CommandeController::class,'delete'])->name('commandes.delete');
            Route::get('commandes/details/{id}',[CommandeController::class,'view'])->name('commandes.view');

            Route::post('factures/addcomment',[CommentsController::class,'addCommentFacture'])->name('factures.add.comment');
            Route::post('devis/addcomment',[CommentsController::class,'addCommentDevis'])->name('devis.add.comment');
            Route::post('commande/addcomment',[CommentsController::class,'addCommentCommande'])->name('commande.add.comment');
            Route::post('comment/update',[CommentsController::class,'updateComment'])->name('comment.update');
            Route::post('comment/delete',[CommentsController::class,'deleteComment'])->name('comment.delete');

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
