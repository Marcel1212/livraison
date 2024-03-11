<?php

use App\Http\Controllers\ProjetEtude\AffectationProjetEtudeController;
use App\Http\Controllers\ProjetEtude\CahierprojetetudeController;
use App\Http\Controllers\ProjetEtude\ProjetEtudeController;
use App\Http\Controllers\ProjetEtude\TraitementProjetEtudeController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth']], function () {
    //Demande projet etude
    Route::get('projetetude', [ProjetEtudeController::class, 'index'])->name('projetetude');
    Route::get('projetetude/index', [ProjetEtudeController::class, 'index'])->name('projetetude.index');
    Route::get('projetetude/create', [ProjetEtudeController::class, 'create'])->name('projetetude.create');
    Route::post('projetetude/store', [ProjetEtudeController::class, 'store'])->name('projetetude.store');
    Route::get('projetetude/{id}/{id_etape}/edit', [ProjetEtudeController::class, 'edit'])->name('projetetude.edit');
    Route::put('projetetude/{id}/{id_etape}/update', [ProjetEtudeController::class, 'update'])->name('projetetude.update');
    Route::get('projetetude/{id}/{id_piece_projet}/deletefpe', [ProjetEtudeController::class, 'deletefpe'])->name('projetetude.deletefpe');

    //Affectation
    Route::get('affectationprojetetude', [AffectationProjetEtudeController::class, 'index'])->name('affectationprojetetude');
    Route::get('affectationprojetetude/index', [AffectationProjetEtudeController::class, 'index'])->name('affectationprojetetude.index');
    Route::get('affectationprojetetude/{id}/{id_etape}/edit', [AffectationProjetEtudeController::class, 'edit'])->name('affectationprojetetude.edit');
    Route::put('affectationprojetetude/{id}/update', [AffectationProjetEtudeController::class, 'update'])->name('affectationprojetetude.update');

    //Traitement de projet d'étude
    Route::get('traitementprojetetude', [TraitementProjetEtudeController::class, 'index'])->name('traitementprojetetude');
    Route::get('traitementprojetetude/index', [TraitementProjetEtudeController::class, 'index'])->name('traitementprojetetude.index');
    Route::get('traitementprojetetude/{id}/{id_etape}/edit', [TraitementProjetEtudeController::class, 'edit'])->name('traitementprojetetude.edit');
    Route::put('traitementprojetetude/{id}/update', [TraitementProjetEtudeController::class, 'update'])->name('traitementprojetetude.update');

    //Commenté pièce
    Route::get('traitementprojetetude/piece/{id}/selectionnee', [TraitementProjetEtudeController::class, 'editPieceSelect'])->name('traitementprojetetude.edit.piece');
    Route::post('traitementprojetetude/piece/commentaire', [TraitementProjetEtudeController::class, 'addPieceCommentaire'])->name('traitementprojetetude.add.piece.commentaire');

    //Cahier
    Route::get('cahierprojetetude/{id}/delete', [CahierprojetetudeController::class, 'delete'])->name('cahierprojetetude.delete');
    Route::get('cahierprojetetude/{id}/{id1}/edit', [CahierprojetetudeController::class, 'edit'])->name('cahierprojetetude.edit');
    Route::put('cahierprojetetude/{id}/{id1}/update', [CahierprojetetudeController::class, 'update'])->name('cahierprojetetude.update');
    Route::get('cahierprojetetude/index', [CahierprojetetudeController::class, 'index'])->name('cahierprojetetude.index');
    Route::get('cahierprojetetude', [CahierprojetetudeController::class, 'index'])->name('cahierprojetetude');
    Route::get('cahierprojetetude/create', [CahierprojetetudeController::class, 'create'])->name('cahierprojetetude.create');
    Route::post('cahierprojetetude/store', [CahierprojetetudeController::class, 'store'])->name('cahierprojetetude.store');
    Route::get('cahierprojetetude/{id}/show', [CahierprojetetudeController::class, 'show'])->name('cahierprojetetude.show');
    Route::get('cahierprojetetude/{id}/etat', [CahierprojetetudeController::class, 'etat'])->name('cahierprojetetude.etat');
    Route::get('cahierprojetetude/{id}/{id2}/agrement', [CahierprojetetudeController::class, 'agrement'])->name('cahierprojetetude.agrement');
    Route::get('cahierprojetetude/{id}/{id2}/{id3}/editer', [CahierprojetetudeController::class, 'editer'])->name('cahierprojetetude.editer');
    Route::post('cahierprojetetude/{id}/{id2}/{id3}/agrementupdate', [CahierprojetetudeController::class, 'agrementupdate'])->name('cahierprojetetude.agrementupdate');

});
