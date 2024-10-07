<?php

use App\Http\Controllers\Habilitation\DemandeHabilitationController;
use App\Http\Controllers\Habilitation\TraitementDemandeHabilitationController;
use App\Http\Controllers\Habilitation\TraitementSuppressionDomaineHabilitationController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth']], function () {

    Route::group(['middleware' => ['can:demandehabilitation-index']], function () {
        Route::get('demandehabilitation/{id}/delete', [DemandeHabilitationController::class, 'delete'])->name('demandehabilitation.delete');
        Route::get('demandehabilitation/{id}/{id1}/edit', [DemandeHabilitationController::class, 'edit'])->name('demandehabilitation.edit');
        Route::put('demandehabilitation/{id}/{id1}/update', [DemandeHabilitationController::class, 'update'])->name('demandehabilitation.update');
        Route::get('demandehabilitation/index', [DemandeHabilitationController::class, 'index'])->name('demandehabilitation.index');
        Route::get('demandehabilitation', [DemandeHabilitationController::class, 'index'])->name('demandehabilitation');
        Route::get('demandehabilitation/create', [DemandeHabilitationController::class, 'create'])->name('demandehabilitation.create');
        Route::post('demandehabilitation/store', [DemandeHabilitationController::class, 'store'])->name('demandehabilitation.store');
        Route::get('demandehabilitation/{id}/show', [DemandeHabilitationController::class, 'show'])->name('demandehabilitation.show');
        Route::get('demandehabilitation/{id}/delete', [DemandeHabilitationController::class, 'delete'])->name('demandehabilitation.delete');
        Route::get('demandehabilitation/{id}/deleteapf', [DemandeHabilitationController::class, 'deleteadh'])->name('demandehabilitation.deleteadh');

        Route::get('demandehabilitation/yancho', [DemandeHabilitationController::class, 'indexyancho'])->name('demandehabilitation');
        Route::get('demandehabilitation/indexyancho', [DemandeHabilitationController::class, 'indexyancho'])->name('demandehabilitation.indexyancho');


        Route::get('demandehabilitation/{id}/{id1}/edityancho', [DemandeHabilitationController::class, 'edityancho'])->name('demandehabilitation.edityancho');




        Route::get('demandehabilitation/{id}/{id1}/editdomaine', [DemandeHabilitationController::class, 'editdomaine'])->name('demandehabilitation.editdomaine');
        Route::post('demandehabilitation/{id}/{id1}/deletedomainestore', [DemandeHabilitationController::class, 'deletedomainestore'])->name('demandehabilitation.deletedomainestore');


        Route::get('demandehabilitation/{id}/suppressiondomaineformation', [DemandeHabilitationController::class, 'suppressiondomaineformation'])->name('demandehabilitation.suppressiondomaineformation');
        Route::post('demandehabilitation/{id}/{id1}/suppressiondomaineformationstore', [DemandeHabilitationController::class, 'suppressiondomaineformationstore'])->name('demandehabilitation.suppressiondomaineformationstore');
        Route::get('demandehabilitation/{id}/{id1}/{id2}/suppressiondomaineformationedit', [DemandeHabilitationController::class, 'suppressiondomaineformationedit'])->name('demandehabilitation.suppressiondomaineformationedit');
        Route::post('demandehabilitation/{id}/{id1}/{id2}/suppressiondomaineformationupdate', [DemandeHabilitationController::class, 'suppressiondomaineformationupdate'])->name('demandehabilitation.suppressiondomaineformationupdate');




	});


    Route::group(['middleware' => ['can:traitementsuppressiondomaine-index']], function () {
        Route::get('traitementsuppressiondomaine/index', [TraitementSuppressionDomaineHabilitationController::class, 'index'])->name('traitementsuppressiondomaine.index');
        Route::get('traitementsuppressiondomaine', [TraitementSuppressionDomaineHabilitationController::class, 'index'])->name('traitementsuppressiondomaine');
        Route::get('traitementsuppressiondomaine/{id}/{id1}/edit', [TraitementSuppressionDomaineHabilitationController::class, 'edit'])->name('traitementsuppressiondomaine.edit');
        Route::put('traitementsuppressiondomaine/{id}/update', [TraitementSuppressionDomaineHabilitationController::class, 'update'])->name('traitementsuppressiondomaine.update');

        Route::get('traitementsuppressiondomaine/affectation', [TraitementSuppressionDomaineHabilitationController::class, 'affectation'])->name('traitementdemandehabilitation.affectation');
        Route::get('traitementsuppressiondomaine/{id}/{id1}/editaffectation', [TraitementSuppressionDomaineHabilitationController::class, 'editaffectation'])->name('traitementsuppressiondomaine.editaffectation');
        Route::put('traitementsuppressiondomaine/{id}/updateaffectation', [TraitementSuppressionDomaineHabilitationController::class, 'updateaffectation'])->name('traitementsuppressiondomaine.updateaffectation');


//
//        Route::get('traitementdemandehabilitation/create', [TraitementDemandeHabilitationController::class, 'create'])->name('traitementdemandehabilitation.create');
//        Route::post('traitementdemandehabilitation/store', [TraitementDemandeHabilitationController::class, 'store'])->name('traitementdemandehabilitation.store');
//        Route::get('traitementdemandehabilitation/{id}/show', [TraitementDemandeHabilitationController::class, 'show'])->name('traitementdemandehabilitation.show');
//        Route::get('traitementdemandehabilitation/{id}/delete', [TraitementDemandeHabilitationController::class, 'delete'])->name('traitementdemandehabilitation.delete');
//        Route::get('traitementdemandehabilitation/{id}/deleteapf', [TraitementDemandeHabilitationController::class, 'deleteadh'])->name('traitementdemandehabilitation.deleteadh');
    });

    Route::get('traitementdemandehabilitation/indexyancho', [TraitementDemandeHabilitationController::class, 'indexyancho'])->name('traitementdemandehabilitation.indexyancho');


    Route::group(['middleware' => ['can:traitementdemandehabilitation-index']], function () {
/*         Route::resources([
            'traitementdemandehabilitation' => TraitementDemandeHabilitationController::class,
        ]); */

        Route::get('traitementdemandehabilitation/{id}/delete', [TraitementDemandeHabilitationController::class, 'delete'])->name('traitementdemandehabilitation.delete');
        Route::get('traitementdemandehabilitation/{id}/{id1}/edit', [TraitementDemandeHabilitationController::class, 'edit'])->name('traitementdemandehabilitation.edit');
        Route::put('traitementdemandehabilitation/{id}/{id1}/update', [TraitementDemandeHabilitationController::class, 'update'])->name('traitementdemandehabilitation.update');
        Route::get('traitementdemandehabilitation/index', [TraitementDemandeHabilitationController::class, 'index'])->name('traitementdemandehabilitation.index');
        Route::get('traitementdemandehabilitation', [TraitementDemandeHabilitationController::class, 'index'])->name('traitementdemandehabilitation');
        Route::get('traitementdemandehabilitation/create', [TraitementDemandeHabilitationController::class, 'create'])->name('traitementdemandehabilitation.create');
        Route::post('traitementdemandehabilitation/store', [TraitementDemandeHabilitationController::class, 'store'])->name('traitementdemandehabilitation.store');
        Route::get('traitementdemandehabilitation/{id}/show', [TraitementDemandeHabilitationController::class, 'show'])->name('traitementdemandehabilitation.show');
        Route::get('traitementdemandehabilitation/{id}/delete', [TraitementDemandeHabilitationController::class, 'delete'])->name('traitementdemandehabilitation.delete');
        Route::get('traitementdemandehabilitation/{id}/deleteapf', [TraitementDemandeHabilitationController::class, 'deleteadh'])->name('traitementdemandehabilitation.deleteadh');
    });

    Route::get('traitementdemandehabilitation/{id}/informationaction', [TraitementDemandeHabilitationController::class, 'informationaction'])->name('traitementdemandehabilitation.informationaction');
    Route::get('traitementdemandehabilitation/{id}/informationbeneficiaireaction', [TraitementDemandeHabilitationController::class, 'informationbeneficiaireformation'])->name('traitementdemandehabilitation.informationbeneficiaireaction');
    Route::post('traitementdemandehabilitation/{id}/update/action/formation', [TraitementDemandeHabilitationController::class, 'traitementactionformation'])->name('traitementdemandehabilitation.action.formation');
    Route::post('traitementdemandehabilitation/{id}/update/beneficiaire/action/formation', [TraitementDemandeHabilitationController::class, 'traitementactionformationbenefiaire'])->name('traitementdemandehabilitation.beneficiaire.action.formation');


});
