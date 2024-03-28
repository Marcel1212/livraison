<?php

use App\Http\Controllers\ProjetEtude\AffectationProjetEtudeController;
use App\Http\Controllers\ProjetEtude\AgreementProjetEtudeController;
use App\Http\Controllers\ProjetEtude\CahierprojetetudeController;
use App\Http\Controllers\ProjetEtude\ComiteGestionProjetEtudeController;
use App\Http\Controllers\ProjetEtude\ComitePermanenteProjetEtudeController;
use App\Http\Controllers\ProjetEtude\ComitePleniereProjetEtudeController;
use App\Http\Controllers\ProjetEtude\CtprojetetudevaliderController;
use App\Http\Controllers\ProjetEtude\ProjetEtudeController;
use App\Http\Controllers\ProjetEtude\SelectionOperateurProjetEtudeController;
use App\Http\Controllers\ProjetEtude\TraitementProjetEtudeController;
use App\Http\Controllers\ProjetEtude\TraitementSelectionOperateurProjetEtudeController;
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



    //Comité plénière
    Route::get('comitepleniereprojetetude', [ComitePleniereProjetEtudeController::class, 'index'])->name('comitepleniereprojetetude');
    Route::get('comitepleniereprojetetude/index', [ComitePleniereProjetEtudeController::class, 'index'])->name('comitepleniereprojetetude.index');
    Route::get('comitepleniereprojetetude/create', [ComitePleniereProjetEtudeController::class, 'create'])->name('comitepleniereprojetetude.create');
    Route::post('comitepleniereprojetetude/store', [ComitePleniereProjetEtudeController::class, 'store'])->name('comitepleniereprojetetude.store');
    Route::get('comitepleniereprojetetude/{id}/{id1}/edit', [ComitePleniereProjetEtudeController::class, 'edit'])->name('comitepleniereprojetetude.edit');
    Route::put('comitepleniereprojetetude/{id}/{id1}/update', [ComitePleniereProjetEtudeController::class, 'update'])->name('comitepleniereprojetetude.update');
    Route::get('comitepleniereprojetetude/{id}/delete', [ComitePleniereProjetEtudeController::class, 'delete'])->name('comitepleniereprojetetude.delete');
    Route::get('comitepleniereprojetetude/{id}/{id2}/{id3}/editer', [ComitePleniereProjetEtudeController::class, 'editer'])->name('comitepleniereprojetetude.editer');
    Route::get('comitepleniereprojetetude/{id}/{id2}/{id3}/cahier', [ComitePleniereProjetEtudeController::class, 'cahier'])->name('comitepleniereprojetetude.cahier');
    Route::put('comitepleniereprojetetude/{id}/{id2}/{id3}/cahierupdate', [ComitePleniereProjetEtudeController::class, 'cahierupdate'])->name('comitepleniereprojetetude.cahierupdate');

    //Workflow de validation
    Route::get('ctprojetetudevalider', [CtprojetetudevaliderController::class, 'index'])->name('ctprojetetudevalider.index');
    Route::get('ctprojetetudevalider/{id_projet_etude}/{id_combi_proc}/edit', [CtprojetetudevaliderController::class, 'edit'])->name('ctprojetetudevalider.edit');
    Route::put('ctprojetetudevalider/{id_projet_etude}/update', [CtprojetetudevaliderController::class, 'update'])->name('ctprojetetudevalider.update');


    //Comité de gestion
    Route::get('comitegestionprojetetude', [ComiteGestionProjetEtudeController::class, 'index'])->name('comitegestionprojetetude');
    Route::get('comitegestionprojetetude/index', [ComiteGestionProjetEtudeController::class, 'index'])->name('comitegestionprojetetude.index');
    Route::get('comitegestionprojetetude/create', [ComiteGestionProjetEtudeController::class, 'create'])->name('comitegestionprojetetude.create');
    Route::post('comitegestionprojetetude/store', [ComiteGestionProjetEtudeController::class, 'store'])->name('comitegestionprojetetude.store');
    Route::get('comitegestionprojetetude/{id}/{id1}/edit', [ComiteGestionProjetEtudeController::class, 'edit'])->name('comitegestionprojetetude.edit');
    Route::put('comitegestionprojetetude/{id}/{id1}/update', [ComiteGestionProjetEtudeController::class, 'update'])->name('comitegestionprojetetude.update');
    Route::get('comitegestionprojetetude/{id}/delete', [ComiteGestionProjetEtudeController::class, 'delete'])->name('comitegestionprojetetude.delete');
    Route::get('comitegestionprojetetude/{id}/{id2}/{id3}/editer', [ComiteGestionProjetEtudeController::class, 'editer'])->name('comitegestionprojetetude.editer');
    Route::get('comitegestionprojetetude/{id}/{id2}/agrement', [ComiteGestionProjetEtudeController::class, 'agrement'])->name('comitegestionprojetetude.agrement');
    Route::put('comitegestionprojetetude/{id}/{id2}/{id3}/agrementupdate', [ComiteGestionProjetEtudeController::class, 'agrementupdate'])->name('comitegestionprojetetude.agrementupdate');

    //Comité permanant
    Route::get('comitepermanenteprojetetude/{id}/delete', [ComitePermanenteProjetEtudeController::class, 'delete'])->name('comitepermanenteprojetetude.delete');
    Route::get('comitepermanenteprojetetude/{id}/{id1}/edit', [ComitePermanenteProjetEtudeController::class, 'edit'])->name('comitepermanenteprojetetude.edit');
    Route::put('comitepermanenteprojetetude/{id}/{id1}/update', [ComitePermanenteProjetEtudeController::class, 'update'])->name('comitepermanenteprojetetude.update');
    Route::get('comitepermanenteprojetetude/index', [ComitePermanenteProjetEtudeController::class, 'index'])->name('comitepermanenteprojetetude.index');
    Route::get('comitepermanenteprojetetude', [ComitePermanenteProjetEtudeController::class, 'index'])->name('comitepermanenteprojetetude');
    Route::get('comitepermanenteprojetetude/create', [ComitePermanenteProjetEtudeController::class, 'create'])->name('comitepermanenteprojetetude.create');
    Route::post('comitepermanenteprojetetude/store', [ComitePermanenteProjetEtudeController::class, 'store'])->name('comitepermanenteprojetetude.store');
    Route::get('comitepermanenteprojetetude/{id}/show', [ComitePermanenteProjetEtudeController::class, 'show'])->name('comitepermanenteprojetetude.show');
    Route::get('comitepermanenteprojetetude/{id}/{id2}/agrement', [ComitePermanenteProjetEtudeController::class, 'agrement'])->name('comitepermanenteprojetetude.agrement');
    Route::get('comitepermanenteprojetetude/{id}/{id2}/{id3}/editer', [ComitePermanenteProjetEtudeController::class, 'editer'])->name('comitepermanenteprojetetude.editer');
    Route::put('comitepermanenteprojetetude/{id}/{id2}/{id3}/agrementupdate', [ComitePermanenteProjetEtudeController::class, 'agrementupdate'])->name('comitepermanenteprojetetude.agrementupdate');

    //agrement
    Route::get('agreementprojetetude', [AgreementProjetEtudeController::class, 'index'])->name('agreementprojetetude');
    Route::get('agreementprojetetude/index', [AgreementProjetEtudeController::class, 'index'])->name('agreementprojetetude.index');
    Route::get('agreementprojetetude/{id}/{id1}/edit', [AgreementProjetEtudeController::class, 'edit'])->name('agreementprojetetude.edit');
    Route::get('agreementprojetetude/{id}/show', [AgreementProjetEtudeController::class, 'show'])->name('agreementprojetetude.show');

    //Sélection opérateur
    Route::get('selectionoperateurprojetetude', [SelectionOperateurProjetEtudeController::class, 'index'])->name('selectionoperateurprojetetude.index');
    Route::get('selectionoperateurprojetetude/{id_projet_etude}/{id_etape}/edit', [SelectionOperateurProjetEtudeController::class, 'edit'])->name('selectionoperateurprojetetude.edit');
    Route::put('selectionoperateurprojetetude/{id_projet_etude}/update', [SelectionOperateurProjetEtudeController::class, 'update'])->name('selectionoperateurprojetetude.update');
    Route::put('selectionoperateurprojetetude/{id_projet_etude}/mark', [SelectionOperateurProjetEtudeController::class, 'mark'])->name('selectionoperateurprojetetude.mark');
    Route::get('selectionoperateurprojetetude/{id_projet_etude}/{id_operateur}/deleteoperateurpe', [SelectionOperateurProjetEtudeController::class, 'deleteoperateurpe'])->name('selectionoperateurprojetetude.deleteoperateurpe');
    Route::post('projetetudeajoutcabinetetrangere', [SelectionOperateurProjetEtudeController::class, 'storeCabinetEtranger'])->name('projetetude.ajoutcabinetetrangere');

    //Traitement sélection opérateur
    Route::get('traitementselectionoperateurprojetetude', [TraitementSelectionOperateurProjetEtudeController::class, 'index'])->name('traitementselectionoperateurprojetetude.index');
    Route::get('traitementselectionoperateurprojetetude/{id_projet_etude}/{id_combi_proc}/edit', [TraitementSelectionOperateurProjetEtudeController::class, 'edit'])->name('traitementselectionoperateurprojetetude.edit');
    Route::put('traitementselectionoperateurprojetetude/{id_projet_etude}/update', [TraitementSelectionOperateurProjetEtudeController::class, 'update'])->name('traitementselectionoperateurprojetetude.update');


});
