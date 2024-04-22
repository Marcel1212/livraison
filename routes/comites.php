<?php

use App\Http\Controllers\Comites\ComitesController;
use App\Http\Controllers\Comites\TraitementComitesController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth']], function () {

    Route::group(['middleware' => ['can:comites-index']], function () {

        Route::get('comites', [ComitesController::class, 'index'])->name('comites');
        Route::get('comites/create', [ComitesController::class, 'create'])->name('comites.create');
        Route::post('comites/store', [ComitesController::class, 'store'])->name('comites.store');
        Route::get('comites/{id}/show', [ComitesController::class, 'show'])->name('comites.show');
        Route::get('comites/{id}/{id2}/{id3}/cahier', [ComitesController::class, 'cahier'])->name('comites.cahier');
        Route::get('comites/{id}/{id2}/{id3}/editer', [ComitesController::class, 'editer'])->name('comites.editer');
        Route::post('comites/{id}/{id2}/{id3}/cahierupdate', [ComitesController::class, 'cahierupdate'])->name('comites.cahierupdate');
        Route::put('comites/{id}/{id1}/update', [ComitesController::class, 'update'])->name('comites.update');
        Route::get('comites/{id}/{id1}/edit', [ComitesController::class, 'edit'])->name('comites.edit');
        Route::get('comites/{id}/delete', [ComitesController::class, 'delete'])->name('comites.delete');

    });

    Route::group(['middleware' => ['can:traitementcomite-index']], function () {

        Route::get('traitementcomite', [TraitementComitesController::class, 'index'])->name('traitementcomite');
        Route::get('traitementcomite/create', [TraitementComitesController::class, 'create'])->name('traitementcomite.create');
        Route::post('traitementcomite/store', [TraitementComitesController::class, 'store'])->name('traitementcomite.store');
        Route::get('traitementcomite/{id}/show', [TraitementComitesController::class, 'show'])->name('traitementcomite.show');
        Route::get('traitementcomite/{id}/{id2}/{id3}/cahier', [TraitementComitesController::class, 'cahier'])->name('traitementcomite.cahier');
        Route::get('traitementcomite/{id}/{id2}/{id3}/editer', [TraitementComitesController::class, 'editer'])->name('traitementcomite.editer');
        Route::put('traitementcomite/{id}/{id2}/{id3}/cahierupdate', [TraitementComitesController::class, 'cahierupdate'])->name('traitementcomite.cahierupdate');
        Route::put('traitementcomite/{id}/{id1}/update', [TraitementComitesController::class, 'update'])->name('traitementcomite.update');
        Route::get('traitementcomite/{id}/{id1}/edit', [TraitementComitesController::class, 'edit'])->name('traitementcomite.edit');
        Route::get('traitementcomite/{id}/{id1}/{id2}/edit/planformation', [TraitementComitesController::class, 'editplanformation'])->name('traitementcomite.edit.planformation');
        Route::get('traitementcomite/{id}/{id1}/{id2}/{id3}/editer/planformation', [TraitementComitesController::class, 'editerplanformation'])->name('traitementcomite.editer.planformation');
        Route::put('traitementcomite/{id}/{id1}/{id2}/{id3}/updater/planformation', [TraitementComitesController::class, 'updater'])->name('traitementcomite.updater.planformation');
        Route::get('traitementcomite/{id}/{id1}/{id2}/edit/projetetude', [TraitementComitesController::class, 'editprojetetude'])->name('traitementcomite.edit.projetetude');
        Route::get('traitementcomite/{id}/{id1}/{id2}/edit/projeformation', [TraitementComitesController::class, 'editprojetformation'])->name('traitementcomite.edit.projetformation');
        Route::get('traitementcomite/{id}/{id1}/{id2}/{id3}/editer/projetformation', [TraitementComitesController::class, 'editerprojetformation'])->name('traitementcomite.editer.projetformation');
        Route::get('traitementcomite/{id}/{id1}/{id2}/{id3}/editer/projetetude', [TraitementComitesController::class, 'editerprojetetude'])->name('traitementcomite.editer.projetetude');
        // Route::get('traitementcomite/{id}/{id1}/{id2}/edit/projetformation', [TraitementComitesController::class, 'editprojetformation'])->name('traitementcomite.edit.projetformation');
        // Route::get('traitementcomite/{id}/{id1}/{id2}/{id3}/editer/projetformation', [TraitementComitesController::class, 'editerprojetformation'])->name('traitementcomite.editer.projetformation');
        Route::put('traitementcomite/{id}/{id1}/{id2}/{id3}/updater/projetetude', [TraitementComitesController::class, 'updater'])->name('traitementcomite.updater');

        //Route::get('traitementcomite/{id}/{id1}/{id2}/edit/projetformation', [TraitementComitesController::class, 'edit'])->name('traitementcomite.edit.projetformation');
        Route::get('traitementcomite/{id}/delete', [TraitementComitesController::class, 'delete'])->name('traitementcomite.delete');

    });

});
