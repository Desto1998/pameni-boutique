<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AvoirController;
use App\Http\Controllers\BonLivraisonController;
use App\Http\Controllers\CaisseController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\DevisController;
use App\Http\Controllers\EntreController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\FournisserController;
use App\Http\Controllers\GestionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\RapportController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AccountValidation;
use App\Http\Middleware\CheckAdmin;
use App\Http\Middleware\LicenceCheck;
use App\Http\Middleware\MenuCaisse;
use App\Http\Middleware\MenuClient;
use App\Http\Middleware\MenuCommande;
use App\Http\Middleware\MenuDevis;
use App\Http\Middleware\MenuFactures;
use App\Http\Middleware\MenuFournisseur;
use App\Http\Middleware\MenuGestion;
use App\Http\Middleware\MenuProduit;
use App\Http\Middleware\MenuRapport;
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

Route::redirect('/', 'login');
Route::get('dologout', [LoginController::class, 'doLogout']);
Route::post('update/pwd', [ForgotPasswordController::class, 'ResetPassword'])->name('update.password');
Route::post('send/reserPassword/link', [ForgotPasswordController::class, 'sendResetPasswordLink'])->name('send.reset.link');
Route::get('resetPassword/infos/{_token}/{email}/{date}', [ForgotPasswordController::class, 'ResetPasswordInfo'])->name('reset.password.data');
Route::view('/privacy-term', 'privacy-term')->name('privacy.term');

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

        //Route for user only for active user with valid licence
        Route::middleware([AccountValidation::class, LicenceCheck::class])->group(function () {
            Route::get('home', [HomeController::class, 'index'])->name('home');

            //Route for for profile account
            Route::get('user/profile', [UserController::class, 'showProfile'])->name('user.profile');
            Route::post('user/updateInfos', [UserController::class, 'updateInfos'])->name('user.edit.infos');
            Route::post('user/updatepassword', [UserController::class, 'updatePassword'])->name('user.edit.password');
            Route::post('user/profile/image', [UserController::class, 'UpdateImage'])->name('user.profil.image');

            // Route for charges
            Route::middleware([MenuGestion::class])->group(function () {
                Route::get('gestion/charges', [GestionController::class, 'charge'])->name('gestion.index');
                Route::get('gestion/charges/load', [GestionController::class, 'loadCharges'])->name('gestion.load.charge');
                Route::post('gestion/charges/add', [GestionController::class, 'storeCharge'])->name('gestion.charge.add');
                Route::post('gestion/charges/delete', [GestionController::class, 'deleteCharge'])->name('gestion.charge.delete');

                // Route for taches
                Route::get('gestion/tasks', [GestionController::class, 'taches'])->name('gestion.tache');
                Route::get('gestion/tasks/load', [GestionController::class, 'loadTaches'])->name('gestion.load.tache');
                Route::post('gestion/tasks/add', [GestionController::class, 'storeTask'])->name('gestion.taches.add');
                Route::post('gestion/tasks/markasdone', [GestionController::class, 'markTaskAsDone'])->name('gestion.taches.markasdone');
                Route::post('gestion/tasks/delete', [GestionController::class, 'deleteTache'])->name('gestion.taches.delete');

                // Route for entreee
                Route::get('gestion/entrees', [EntreController::class, 'index'])->name('gestion.entrees');
                Route::get('gestion/entrees/load', [EntreController::class, 'loadEntree'])->name('gestion.load.entrees');
                Route::post('gestion/entrees/add', [EntreController::class, 'storeEntree'])->name('gestion.entrees.add');
                Route::post('gestion/entrees/delete', [EntreController::class, 'deleteEntree'])->name('gestion.entrees.delete');
            });

            Route::middleware([MenuCaisse::class])->group(function () {
                // Route for caisse
                Route::get('gestion/caisses', [CaisseController::class, 'index'])->name('gestion.caisses');
                Route::get('gestion/caisses/load', [CaisseController::class, 'loadCaisses'])->name('gestion.load.caisse');
            });

            Route::post('gestion/calendar', [UserController::class, 'UpdateImage'])->name('gestion.calendrier');
            Route::middleware([MenuRapport::class])->group(function () {
                //Route for rapport
                Route::get('rapport/charge', [RapportController::class, 'showChargeForm'])->name('rapport.charge');
                Route::get('rapport/charge/print', [RapportController::class, 'printCharge'])->name('rapport.charge.print');
                Route::get('rapport/ventes', [RapportController::class, 'showVenteForm'])->name('rapport.vente');
                Route::get('rapport/ventes/print', [RapportController::class, 'printVente'])->name('rapport.vente.print');

            });

            Route::middleware([MenuProduit::class])->group(function () {
                //Route for categorie
                Route::get('categorie/index',[CategorieController::class,'listCategories'])->name('categorie.all');
                Route::get('categorie/load',[CategorieController::class,'loadCategorie'])->name('categorie.load');
                Route::post('categorie/store',[CategorieController::class,'storeCategorie'])->name('categorie.store');
                Route::post('categorie/delete',[CategorieController::class,'deleteCategore'])->name('categorie.delete');
                //Routes for produit
                Route::get('product/index',[ProduitController::class,'listproduct'])->name('produit.all');
                Route::get('product/list',[ProduitController::class,'loadProducts'])->name('produit.load');
                Route::get('product/details/{id}',[ProduitController::class,'viewProduct'])->name('produit.details');
                Route::post('product/store',[ProduitController::class,'storeProduct'])->name('produit.store');
                Route::post('product/update',[ProduitController::class,'updateProduct'])->name('produit.update');
                Route::post('product/delete',[ProduitController::class,'deleteProduct'])->name('produit.delete');
            });

            Route::middleware([MenuClient::class])->group(function () {
                //Routes for client
                Route::get('client/index',[ClientController::class,'index'])->name('client.all');
                Route::get('client/load',[ClientController::class,'loadClients'])->name('client.load');
                Route::post('client/store',[ClientController::class,'store'])->name('client.store');
                Route::post('client/update',[ClientController::class,'update'])->name('client.update');
                Route::post('client/delete',[ClientController::class,'delete'])->name('client.delete');
                Route::get('client/edit/{id}',[ClientController::class,'showEditForm'])->name('client.edit');
                Route::get('client/details/{id}',[ClientController::class,'view'])->name('client.view');
            });

            Route::middleware([MenuFournisseur::class])->group(function () {
                //Routes for fournisseur
                Route::get('fournisseur/index',[FournisserController::class,'index'])->name('fournisseur.all');
                Route::get('fournisseur/load',[FournisserController::class,'loadFournisseur'])->name('fournisseur.load');
                Route::post('fournisseur/store',[FournisserController::class,'store'])->name('fournisseur.store');
                Route::post('fournisseur/update',[FournisserController::class,'update'])->name('fournisseur.update');
                Route::get('fournisseur/edit/{id}',[FournisserController::class,'showEditForm'])->name('fournisseur.edit');
                Route::post('fournisseur/delete',[FournisserController::class,'delete'])->name('fournisseur.delete');
                Route::get('fournisseur/details/{id}',[FournisserController::class,'view'])->name('fournisseur.view');
            });

            Route::middleware([MenuDevis::class])->group(function () {
                //Route for devis
                Route::get('devis/index',[DevisController::class,'index'])->name('devis.all');
                Route::get('devis/load/{id}',[DevisController::class,'loadDevis'])->name('devis.load');
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

                // Route pour bon de livraison
                Route::get('bonLivraison/index',[BonLivraisonController::class,'index'])->name('bon.index');
                Route::get('bonLivraison/load/{id}',[BonLivraisonController::class,'loadBon'])->name('bon.loadAll');
                Route::get('bonLivraison/edit/{id}',[BonLivraisonController::class,'showEditForm'])->name('bonLivraison.edit');
                Route::post('bonLivraison/edit/update',[BonLivraisonController::class,'edit'])->name('bonLivraison.edit.update');
                Route::post('bonLivraison/store',[BonLivraisonController::class,'store'])->name('bon.store');
                Route::get('bonLivraison/print/{id}',[BonLivraisonController::class,'printBon'])->name('bon.print');
                Route::get('bonLivraison/view/{id}',[BonLivraisonController::class,'viewDetail'])->name('bon.view');
                Route::post('bonLivraison/delete',[BonLivraisonController::class,'delete'])->name('bon.delete');
            });

            Route::middleware([MenuFactures::class])->group(function () {
                //Route for factures
                Route::get('factures/index',[FactureController::class,'index'])->name('factures.all');
                Route::get('factures/load/{id}',[FactureController::class,'loadFactures'])->name('factures.load');
                Route::get('factures/add',[FactureController::class,'showAddForm'])->name('factures.add');
                Route::post('factures/store',[FactureController::class,'store'])->name('factures.store');
                Route::get('factures/edit/{id}',[FactureController::class,'showEditForm'])->name('factures.edit');
                Route::post('factures/edit/store',[FactureController::class,'edit'])->name('factures.edit.store');
                Route::get('factures/details/{id}',[FactureController::class,'viewDetail'])->name('factures.view');
                Route::post('factures/delete',[FactureController::class,'delete'])->name('factures.delete');
                Route::post('factures/valider',[FactureController::class,'validerFactures'])->name('factures.valider');
                Route::post('factures/bloquer',[FactureController::class,'bloquerFactures'])->name('factures.bloquer');

                Route::get('factures/print/{id}',[FactureController::class,'printFactures'])->name('factures.print');
                Route::post('factures/remove/produit',[FactureController::class,'removeProduit'])->name('factures.remove.produit');

                Route::post('factures/paiement/store',[FactureController::class,'addPaiement'])->name('factures.paiement.store');
                Route::post('factures/paiement/delete',[FactureController::class,'deletePaiement'])->name('factures.paiement.delete');
                Route::post('factures/paiement/update',[PaiementController::class,'updatePaiement'])->name('factures.paiement.update');
                Route::post('factures/checkAmount',[FactureController::class,'checkAmount'])->name('factures.checkAmount');

                // Route pour facture avoir
                Route::get('factures/avoirs/index',[AvoirController::class,'index'])->name('avoir.index');
                Route::get('factures/avoir/load/{id}',[AvoirController::class,'loadAvoir'])->name('avoir.loadAll');
                Route::get('factures/avoir/edit/{id}',[AvoirController::class,'showEditForm'])->name('avoir.edit');
                Route::post('factures/avoir/edit/update',[AvoirController::class,'edit'])->name('avoir.edit.update');
                Route::post('factures/avoir/store',[AvoirController::class,'store'])->name('avoir.store');
                Route::get('factures/avoir/print/{id}',[AvoirController::class,'printFactures'])->name('avoir.print');
                Route::get('factures/avoir/view/{id}',[AvoirController::class,'viewDetail'])->name('avoir.view');
                Route::post('factures/avoir/delete',[AvoirController::class,'delete'])->name('avoir.delete');
                Route::post('factures/avoir/valider',[AvoirController::class,'validerAvoir'])->name('avoir.valider');
                Route::post('factures/avoir/bloquer',[AvoirController::class,'bloquerAvoir'])->name('avoir.bloquer');

                Route::post('factures/avoir/recouvrement',[AvoirController::class,'recouvrement'])->name('avoir.recouvrement');

                Route::post('factures/avoir/removeProduct',[AvoirController::class,'removeProduit'])->name('avoir.retirerProduit');

                // Routes pour historique des factures
                Route::post('factures/history/archivate',[LogController::class,'archivate'])->name('history.archive');
                Route::post('factures/history/delete',[LogController::class,'delete'])->name('history.delete');
                Route::get('factures/history/index',[LogController::class,'index'])->name('history.index');

            });

            Route::middleware([MenuCommande::class])->group(function () {
                //Route for commandes
                Route::get('commandes/index',[CommandeController::class,'index'])->name('commandes.all');
                Route::get('commandes/load/{id}',[CommandeController::class,'loadCommandes'])->name('commandes.load');
                Route::get('commandes/add',[CommandeController::class,'showAddForm'])->name('commandes.add');
                Route::post('commandes/store',[CommandeController::class,'store'])->name('commandes.store');
                Route::get('commandes/edit/{id}',[CommandeController::class,'showEditForm'])->name('commandes.edit');
                Route::post('commandes/edit/store',[CommandeController::class,'edit'])->name('commandes.edit.store');
                Route::post('commandes/delete',[CommandeController::class,'delete'])->name('commandes.delete');
                Route::post('commandes/valider',[CommandeController::class,'validerCommande'])->name('commandes.valider');
                Route::post('commandes/bloquer',[CommandeController::class,'bloquerCommande'])->name('commandes.bloquer');
                Route::get('commandes/details/{id}',[CommandeController::class,'viewDetail'])->name('commandes.view');

                Route::get('commandes/print/{id}',[CommandeController::class,'printCommandes'])->name('commandes.print');
                Route::post('commandes/print/currency',[CommandeController::class,'printCurrencyChange'])->name('commandes.print.currency');
                Route::post('commandes/remove/produit',[CommandeController::class,'removeProduit'])->name('commandes.remove.produit');
                Route::post('commandes/stock/produit',[CommandeController::class,'migrateToStock'])->name('commandes.stock.produit');
            });


            //Route pour les commentaires
            Route::post('factures/addcomment',[CommentsController::class,'addCommentFacture'])->name('factures.add.comment');
            Route::post('devis/addcomment',[CommentsController::class,'addCommentDevis'])->name('devis.add.comment');
            Route::post('commande/addcomment',[CommentsController::class,'addCommentCommande'])->name('commande.add.comment');
            Route::post('avoir/addcomment',[CommentsController::class,'addCommentAvoir'])->name('avoir.add.comment');
            Route::post('bonLiv/addcomment',[CommentsController::class,'addCommentBon'])->name('bonLiv.add.comment');
            Route::post('comment/update',[CommentsController::class,'updateComment'])->name('comment.update');
            Route::post('comment/delete',[CommentsController::class,'deleteComment'])->name('comment.delete');

            //load notification
            Route::get('notification/notify',[NotificationController::class,'notify'])->name('notify.load');
            Route::view('/notification', 'notify')->name('notify.all');

            //Route for admin prefix with admin depend on  middleware to allow only admin
            Route::prefix('admin')->group(function () {
                Route::middleware([CheckAdmin::class,\App\Http\Middleware\MenuUser::class])->group(function () {
                    // routes pour les compte utilisateurs
                    Route::get('user/all', [UserController::class, 'index'])->name('user.all');
                    Route::view('user/new', 'user.add')->name('user.add');
                    Route::post('user/new/store', [UserController::class, 'storeUser'])->name('user.add.store');
                    Route::get('user/edit/{id}', [UserController::class, 'editUser'])->name('user.edit');
                    Route::post('user/edit/store', [UserController::class, 'updateUser'])->name('user.edit.store');
                    Route::post('user/delete', [UserController::class, 'deleteUser'])->name('user.delete');
                    Route::get('user/activate/{id}', [UserController::class, 'activate'])->name('activate_compte');
                    Route::get('user/block/{id}', [UserController::class, 'block'])->name('block_compte');

                    Route::post('user/menu', [MenuController::class, 'storeMenu'])->name('set.user.menu');
                });
            });


        });

    });

});
