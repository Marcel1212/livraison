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
        Route::get('comitetechniques/{id}/{id1}/{id2}/edit/planformation', [ComitesTechniquesController::class, 'editplanformation'])->name('comitetechniques.edit.planformation');
        Route::get('comitetechniques/{id}/{id1}/{id2}/edit/habilitation', [ComitesTechniquesController::class, 'edithabilitation'])->name('comitetechniques.edit.habilitation');
        Route::get('comitetechniques/{id}/{id1}/{id2}/edit/projetetude', [ComitesTechniquesController::class, 'editprojetetude'])->name('comitetechniques.edit.projetetude');
        Route::get('comitetechniques/{id}/{id1}/{id2}/edit/projetformation', [ComitesTechniquesController::class, 'editprojetformation'])->name('comitetechniques.edit.projetformation');
        Route::get('comitetechniques/{id}/{id1}/{id2}/show/habilitation', [ComitesTechniquesController::class, 'showficheanalysehabilitation'])->name('comitetechniques.show.ficheanalyse');

    });

    Route::group(['middleware' => ['can:traitementcomitetechniques-index']], function () {

        Route::get('traitementcomitetechniques', [TraitementComitesTechniquesController::class, 'index'])->name('traitementcomitetechniques');
        Route::get('traitementcomitetechniques/create', [TraitementComitesTechniquesController::class, 'create'])->name('traitementcomitetechniques.create');
        Route::post('traitementcomitetechniques/store', [TraitementComitesTechniquesController::class, 'store'])->name('traitementcomitetechniques.store');
        Route::get('traitementcomitetechniques/{id}/show', [TraitementComitesTechniquesController::class, 'show'])->name('traitementcomitetechniques.show');
        Route::get('traitementcomitetechniques/{id}/{id2}/{id3}/cahier', [TraitementComitesTechniquesController::class, 'cahier'])->name('traitementcomitetechniques.cahier');
        Route::get('traitementcomitetechniques/{id}/{id2}/{id3}/editer', [TraitementComitesTechniquesController::class, 'editer'])->name('traitementcomitetechniques.editer');
        Route::put('traitementcomitetechniques/{id}/{id2}/{id3}/cahierupdate', [TraitementComitesTechniquesController::class, 'cahierupdate'])->name('traitementcomitetechniques.cahierupdate');
        Route::put('traitementcomitetechniques/{id}/{id2}/{id3}/comitetechnique/update/habilitation', [TraitementComitesTechniquesController::class, 'comitetechniqueupdatehabilitation'])->name('traitementcomitetechniques.comitetechnique.update.habilitation');
        Route::put('traitementcomitetechniques/{id}/{id1}/update', [TraitementComitesTechniquesController::class, 'update'])->name('traitementcomitetechniques.update');
        Route::get('traitementcomitetechniques/{id}/{id1}/edit', [TraitementComitesTechniquesController::class, 'edit'])->name('traitementcomitetechniques.edit');
        Route::get('traitementcomitetechniques/{id}/{id1}/{id2}/edit/planformation', [TraitementComitesTechniquesController::class, 'editplanformation'])->name('traitementcomitetechniques.edit.planformation');
        Route::get('traitementcomitetechniques/{id}/{id1}/{id2}/edit/habilitation', [TraitementComitesTechniquesController::class, 'edithabilitation'])->name('traitementcomitetechniques.edit.habilitation');
        Route::put('traitementcomitetechniques/{id}/{id1}/{id2}/edit/habilitation/update', [TraitementComitesTechniquesController::class, 'edithabilitationupdate'])->name('traitementcomitetechniques.update.habilitation');
        Route::get('traitementcomitetechniques/{id}/{id1}/{id2}/show/habilitation', [TraitementComitesTechniquesController::class, 'showficheanalysehabilitation'])->name('traitementcomitetechniques.show.ficheanalyse');
        Route::get('traitementcomitetechniques/{id}/{id1}/{id2}/edit/projetetude', [TraitementComitesTechniquesController::class, 'editprojetetude'])->name('traitementcomitetechniques.edit.projetetude');
        Route::put('traitementcomitetechniques/{id}/{id2}/{id3}/cahierupdateprojetetude', [TraitementComitesTechniquesController::class, 'cahierupdateprojetetude'])->name('traitementcomitetechniques.cahierupdateprojetetude');

        Route::get('traitementcomitetechniques/{id}/{id1}/{id2}/edit/projetformation', [TraitementComitesTechniquesController::class, 'editprojetformation'])->name('traitementcomitetechniques.edit.projetformation');
        Route::get('traitementcomitetechniques/{id}/delete', [TraitementComitesTechniquesController::class, 'delete'])->name('traitementcomitetechniques.delete');

    });

    Route::get('/avisglobalcomitetechniquehabilitation/{id}/{id1}/{id2}', [ComitesTechniquesController::class, 'avisglobalcomitetechniquehabilitation']);
    Route::get('/comitetechniques/{id}/rapport', [ComitesTechniquesController::class, 'rapportcomitetechnique'])->name('comitetechniques.rapport');
    Route::put('/avisglobalcomitetechnique/{id}/{id1}/{id2}/update', [ComitesTechniquesController::class, 'avisglobalcomitetechnique']);

    Route::get('/page-commentaire-comite-technique/{id}/{id1}/{id2}', [TraitementComitesTechniquesController::class, 'CommentaireComitetechnique']);
    Route::get('/page-commentaire-all-comite-technique/{id}/{id1}/{id2}', [TraitementComitesTechniquesController::class, 'CommentaireComitetechniqueall']);
    Route::post('traitementcomitetechniques/{id}/commentairetoutuserhabilitation', [TraitementComitesTechniquesController::class, 'commentairetoutuserhabilitation'])->name('traitementcomitetechniques.commentairetoutuserhabilitation');




    Route::get('traitementcomitetechniques/{id}/{id1}/informationaction', [TraitementComitesTechniquesController::class, 'informationaction'])->name('traitementcomitetechniques.informationaction');
    Route::get('traitementcomitetechniques/{id}/commentairetoutuser', [TraitementComitesTechniquesController::class, 'commentairetoutuser'])->name('traitementcomitetechniques.commentairetoutuser');
    Route::post('traitementcomitetechniques/{id}/update/action/formation', [TraitementComitesTechniquesController::class, 'traitementactionformation'])->name('traitementcomitetechniques.action.formation');
    Route::post('traitementcomitetechniques/{id}/update/action/formation/corriger', [TraitementComitesTechniquesController::class, 'traitementactionformationcorriger'])->name('traitementcomitetechniques.action.formation.corriger');


});
