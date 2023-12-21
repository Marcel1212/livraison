<?php

use Illuminate\Support\Facades\Route;

Route::get('/reload-captcha', [App\Http\Controllers\ConnexionController::class, 'reloadCaptcha'])->name('reloadCaptcha');

Route::match(['get', 'post'], '/', [App\Http\Controllers\IndexController::class, 'index'])->name('/');
Route::match(['get', 'post'], '/login', [App\Http\Controllers\ConnexionController::class, 'login'])->name('login');
Route::match(['get', 'post'], '/enrolements', [App\Http\Controllers\EnrolementController::class, 'create'])->name('enrolements');
Route::match(['get', 'post'], '/projetetude', [App\Http\Controllers\ProjetEtudeController::class, 'index'])->name('projetetude.index');
Route::match(['get', 'post'], '/enrolements.store', [App\Http\Controllers\EnrolementController::class, 'store'])->name('enrolements.store');
Route::get('/secteuractivilitelistes/{id}', [App\Http\Controllers\EnrolementController::class, 'getsecteuractivilitelistes']);
//Route::resources(['enrolement' => App\Http\Controllers\EnrolementController::class,]);
Route::match(['get', 'post'], '/connexion', [App\Http\Controllers\ConnexionController::class, 'login'])->name('connexion');
Route::match(['post'], '/test', [App\Http\Controllers\PlanFormationController::class, 'test'])->name('test');
Route::get('/deconnexion', [App\Http\Controllers\HomeController::class, 'deconnexion']);
Route::group(['middleware' => ['auth']], function () {
    //Route::group(['middleware' => ['can:role-index']], function () {
        Route::resources([
            'roles' => App\Http\Controllers\RoleController::class,
            'users' => App\Http\Controllers\UserController::class,
            'permissions' => App\Http\Controllers\PermissionController::class,
            'menus' => App\Http\Controllers\MenuController::class,
            'sousmenus' => App\Http\Controllers\SousmenuController::class,
            'agence' => App\Http\Controllers\AgenceController::class,
            'direction' => App\Http\Controllers\DirectionController::class,
            'departement' => App\Http\Controllers\DepartementController::class,
            'service' => App\Http\Controllers\ServiceController::class,
            'activites' => App\Http\Controllers\ActivitesController::class,
            'centreimpot' => App\Http\Controllers\CentreImpotController::class,
            'localite' => App\Http\Controllers\LocaliteController::class,
            'projetetude' => App\Http\Controllers\ProjetEtudeController::class,
            'projetformation' => App\Http\Controllers\ProjetFormationController::class,
            'enrolement' => App\Http\Controllers\EnrolementController::class,
            'statutoperations' => App\Http\Controllers\StatutOperationController::class,
            'motifs' => App\Http\Controllers\MotifController::class,
            //'planformation' => App\Http\Controllers\PlanFormationController::class,
            'typeentreprise' => App\Http\Controllers\TypeEntrepriseController::class,
            'butformation' => App\Http\Controllers\ButFormationController::class,
            'typeformation' => App\Http\Controllers\TypeFormationController::class,
            'traitementplanformation' => App\Http\Controllers\TratementPlanFormationController::class,
            'periodeexercice' => App\Http\Controllers\PeriodeExerciceController::class,
            'ctplanformation' => App\Http\Controllers\CtplanformationController::class,
            'ctprojetetude' => App\Http\Controllers\CtprojetetudeController::class,
            'ctplanformationvalider' => App\Http\Controllers\CtplanformationvaliderController::class,
            'comitepleniere' => App\Http\Controllers\ComitePleniereController::class,
            'formejuridique' => App\Http\Controllers\FormeJuridiqueController::class,
            'secteuractivite' => App\Http\Controllers\SecteurActiviteController::class,
            'partentreprise' => App\Http\Controllers\PartEntrepriseController::class,
            'typecomite' => App\Http\Controllers\TypeComiteController::class,
        ]);
    //});

    Route::get('comitepleniere/{id}/delete', [App\Http\Controllers\ComitePleniereController::class, 'delete'])->name('comitepleniere.delete');
    Route::get('comitepleniere/{id}/{id2}/cahier', [App\Http\Controllers\ComitePleniereController::class, 'cahier'])->name('comitepleniere.cahier');
    Route::get('comitepleniere/{id}/{id2}/editer', [App\Http\Controllers\ComitePleniereController::class, 'editer'])->name('comitepleniere.editer');
    Route::post('comitepleniere/{id}/{id2}/cahierupdate', [App\Http\Controllers\ComitePleniereController::class, 'cahierupdate'])->name('comitepleniere.cahierupdate');

    Route::get('/departementlist/{id}', [App\Http\Controllers\ListeLierController::class, 'getDepartements']);
    Route::get('/servicelist/{id}', [App\Http\Controllers\ListeLierController::class, 'getServices']);
    Route::get('planformation/{id}/delete', [App\Http\Controllers\PlanFormationController::class, 'delete'])->name('planformation.delete');
    Route::get('planformation/{id}/{id1}/edit', [App\Http\Controllers\PlanFormationController::class, 'edit'])->name('planformation.edit');
    Route::put('planformation/{id}/{id1}/update', [App\Http\Controllers\PlanFormationController::class, 'update'])->name('planformation.update');
    Route::get('planformation/index', [App\Http\Controllers\PlanFormationController::class, 'index'])->name('planformation.index');
    Route::get('planformation', [App\Http\Controllers\PlanFormationController::class, 'index'])->name('planformation');
    Route::get('planformation/create', [App\Http\Controllers\PlanFormationController::class, 'create'])->name('planformation.create');
    Route::post('planformation/store', [App\Http\Controllers\PlanFormationController::class, 'store'])->name('planformation.store');
    Route::get('planformation/{id}/show', [App\Http\Controllers\PlanFormationController::class, 'show'])->name('planformation.show');


    Route::get('planformation/{id}/deleteapf', [App\Http\Controllers\PlanFormationController::class, 'deleteapf'])->name('planformation.deleteapf');
    Route::get('ctplanformationvalider/{id}/{id2}/editer', [App\Http\Controllers\CtplanformationvaliderController::class, 'editer'])->name('ctplanformationvalider.editer');
    Route::get('agence/{id}/delete', [App\Http\Controllers\AgenceController::class, 'delete'])->name('agence.delete');
    Route::get('users/{id}/delete', [App\Http\Controllers\UserController::class, 'delete'])->name('users.delete');
    Route::get('/dashboard', [App\Http\Controllers\ConnexionController::class, 'dashboard'])->name('dashboard');
    Route::match(['get', 'post'], '/menuprofil', [App\Http\Controllers\GenerermenuController::class, 'parametragemenu'])->name('menuprofil');
    Route::match(['get', 'post'], '/profil', [App\Http\Controllers\HomeController::class, 'profil'])->name('profil');
    Route::match(['get', 'post'], '/menuprofillayout/{id}', [App\Http\Controllers\GenerermenuController::class, 'menuprofillayout'])->name('menuprofillayout');
    Route::match(['get', 'post'], '/modifiermotdepasse', [App\Http\Controllers\HomeController::class, 'updatepassword'])->name('modifier.mot.passe');

    Route::group(['middleware' => ['can:role-index']], function () {
        Route::match(['get', 'post'], '/parametresysteme', [App\Http\Controllers\ParametreController::class, 'parametresysteme'])->name('parametresysteme');
        Route::match(['get', 'post'], '/creerparametresysteme', [App\Http\Controllers\ParametreController::class, 'creerparametresysteme'])->name('creerparametresysteme');
        Route::match(['get', 'post'], '/projetetudesoumettre/{id}', [App\Http\Controllers\ProjetEtudeController::class, 'projetetudesoumettre'])->name('projetetudesoumettre');
        Route::match(['get', 'post'], '/modifierparametresysteme/{id}', [App\Http\Controllers\ParametreController::class, 'modifierparametresysteme'])->name('modifierparametresysteme');
        Route::match(['get', 'post'], '/activeparametresysteme/{id}/{id1}', [App\Http\Controllers\ParametreController::class, 'activeparametresysteme'])->name('activeparametresysteme');
        Route::match(['get', 'post'], '/desactiveparametresysteme/{id}/{id1}', [App\Http\Controllers\ParametreController::class, 'desactiveparametresysteme'])->name('desactiveparametresysteme');
    });

    /*************************** Processus ***************************/
    Route::match(['get'], '/processus', [App\Http\Controllers\ProcessusController::class, 'index'])->name('processus');
    Route::match(['get', 'post'], '/processus/create', [App\Http\Controllers\ProcessusController::class, 'create'])->name('processusadd');
    Route::match(['get', 'post'], '/processus/edit/{id}', [App\Http\Controllers\ProcessusController::class, 'edit'])->name('processusedit');

    /*************************** demandes ***************************/
    Route::match(['get'], '/demandencours', [App\Http\Controllers\DemandeController::class, 'demandencours'])->name('demandencours');
    Route::match(['get'], '/demanderejetes', [App\Http\Controllers\DemandeController::class, 'demanderejetes'])->name('demanderejetes');


});
