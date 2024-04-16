<?php

use App\Http\Controllers\Comites\ComitesTechniquesController;
use App\Http\Controllers\Comites\TraitementComitesTechniquesController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth']], function () {

    Route::group(['middleware' => ['can:comitetechniques-index']], function () {

        Route::get('comitetechniques', [ComitesTechniquesController::class, 'index'])->name('comitetechniques');
        Route::get('comitetechniques/create', [ComitesTechniquesController::class, 'create'])->name('comitetechniques.create');
        Route::post('comitetechniques/store', [ComitesTechniquesController::class, 'store'])->name('comitetechniques.store');
        Route::get('comitetechniques/{id}/show', [ComitesTechniquesController::class, 'show'])->name('comitetechniques.show');
        Route::get('comitetechniques/{id}/{id2}/{id3}/cahier', [ComitesTechniquesController::class, 'cahier'])->name('comitetechniques.cahier');
        Route::get('comitetechniques/{id}/{id2}/{id3}/editer', [ComitesTechniquesController::class, 'editer'])->name('comitetechniques.editer');
        Route::post('comitetechniques/{id}/{id2}/{id3}/cahierupdate', [ComitesTechniquesController::class, 'cahierupdate'])->name('comitetechniques.cahierupdate');
        Route::put('comitetechniques/{id}/{id1}/update', [ComitesTechniquesController::class, 'update'])->name('comitetechniques.update');
        Route::get('comitetechniques/{id}/{id1}/edit', [ComitesTechniquesController::class, 'edit'])->name('comitetechniques.edit');
        Route::get('comitetechniques/{id}/delete', [ComitesTechniquesController::class, 'delete'])->name('comitetechniques.delete');

    });

    Route::group(['middleware' => ['can:traitementcomitetechniques-index']], function () {

        Route::get('traitementcomitetechniques', [TraitementComitesTechniquesController::class, 'index'])->name('traitementcomitetechniques');
        Route::get('traitementcomitetechniques/create', [TraitementComitesTechniquesController::class, 'create'])->name('traitementcomitetechniques.create');
        Route::post('traitementcomitetechniques/store', [TraitementComitesTechniquesController::class, 'store'])->name('traitementcomitetechniques.store');
        Route::get('traitementcomitetechniques/{id}/show', [TraitementComitesTechniquesController::class, 'show'])->name('traitementcomitetechniques.show');
        Route::get('traitementcomitetechniques/{id}/{id2}/{id3}/cahier', [TraitementComitesTechniquesController::class, 'cahier'])->name('traitementcomitetechniques.cahier');
        Route::get('traitementcomitetechniques/{id}/{id2}/{id3}/editer', [TraitementComitesTechniquesController::class, 'editer'])->name('traitementcomitetechniques.editer');
        Route::put('traitementcomitetechniques/{id}/{id2}/{id3}/cahierupdate', [TraitementComitesTechniquesController::class, 'cahierupdate'])->name('traitementcomitetechniques.cahierupdate');
        Route::put('traitementcomitetechniques/{id}/{id1}/update', [TraitementComitesTechniquesController::class, 'update'])->name('traitementcomitetechniques.update');
        Route::get('traitementcomitetechniques/{id}/{id1}/edit', [TraitementComitesTechniquesController::class, 'edit'])->name('traitementcomitetechniques.edit');
        Route::get('traitementcomitetechniques/{id}/{id1}/{id2}/edit/planformation', [TraitementComitesTechniquesController::class, 'editplanformation'])->name('traitementcomitetechniques.edit.planformation');
        Route::get('traitementcomitetechniques/{id}/{id1}/{id2}/edit/projetetude', [TraitementComitesTechniquesController::class, 'editprojetetude'])->name('traitementcomitetechniques.edit.projetetude');
        Route::put('traitementcomitetechniques/{id}/{id2}/{id3}/cahierupdateprojetetude', [TraitementComitesTechniquesController::class, 'cahierupdateprojetetude'])->name('traitementcomitetechniques.cahierupdateprojetetude');

        Route::get('traitementcomitetechniques/{id}/{id1}/{id2}/edit/projetformation', [TraitementComitesTechniquesController::class, 'editprojetformation'])->name('traitementcomitetechniques.edit.projetformation');
        Route::get('traitementcomitetechniques/{id}/delete', [TraitementComitesTechniquesController::class, 'delete'])->name('traitementcomitetechniques.delete');

    });

});
