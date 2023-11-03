<?php

use Illuminate\Support\Facades\Route;

Route::get('/reload-captcha', [App\Http\Controllers\ConnexionController::class, 'reloadCaptcha'])->name('reloadCaptcha');

Route::match(['get', 'post'], '/', [App\Http\Controllers\IndexController::class, 'index'])->name('/');
Route::match(['get', 'post'], '/login', [App\Http\Controllers\ConnexionController::class, 'login'])->name('login');
Route::match(['get', 'post'], '/enrolements', [App\Http\Controllers\EnrolementController::class, 'create'])->name('enrolements');
Route::match(['get', 'post'], '/enrolements.store', [App\Http\Controllers\EnrolementController::class, 'store'])->name('enrolements.store');
//Route::resources(['enrolement' => App\Http\Controllers\EnrolementController::class,]);
Route::match(['get', 'post'], '/connexion', [App\Http\Controllers\ConnexionController::class, 'login'])->name('connexion');
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
            'enrolement' => App\Http\Controllers\EnrolementController::class,
            'statutoperations' => App\Http\Controllers\StatutOperationController::class,
            'motifs' => App\Http\Controllers\MotifController::class,
        ]);
    //});
    Route::get('/dashboard', [App\Http\Controllers\ConnexionController::class, 'dashboard'])->name('dashboard');
    Route::match(['get', 'post'], '/menuprofil', [App\Http\Controllers\GenerermenuController::class, 'parametragemenu'])->name('menuprofil');
    Route::match(['get', 'post'], '/profil', [App\Http\Controllers\HomeController::class, 'profil'])->name('profil');
    Route::match(['get', 'post'], '/menuprofillayout/{id}', [App\Http\Controllers\GenerermenuController::class, 'menuprofillayout'])->name('menuprofillayout');
    Route::match(['get', 'post'], '/modifiermotdepasse', [App\Http\Controllers\HomeController::class, 'updatepassword'])->name('modifier.mot.passe');

    Route::group(['middleware' => ['can:role-index']], function () {
        Route::match(['get', 'post'], '/parametresysteme', [App\Http\Controllers\ParametreController::class, 'parametresysteme'])->name('parametresysteme');
        Route::match(['get', 'post'], '/creerparametresysteme', [App\Http\Controllers\ParametreController::class, 'creerparametresysteme'])->name('creerparametresysteme');
        Route::match(['get', 'post'], '/modifierparametresysteme/{id}', [App\Http\Controllers\ParametreController::class, 'modifierparametresysteme'])->name('modifierparametresysteme');
        Route::match(['get', 'post'], '/activeparametresysteme/{id}/{id1}', [App\Http\Controllers\ParametreController::class, 'activeparametresysteme'])->name('activeparametresysteme');
        Route::match(['get', 'post'], '/desactiveparametresysteme/{id}/{id1}', [App\Http\Controllers\ParametreController::class, 'desactiveparametresysteme'])->name('desactiveparametresysteme');
    });
});
