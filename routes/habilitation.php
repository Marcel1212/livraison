<?php

use App\Http\Controllers\Habilitation\DemandeHabilitationController;
use App\Http\Controllers\Habilitation\HabilitationRendezVousController;
use App\Http\Controllers\Habilitation\TraitementDemandeHabilitationController;
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
	});

    Route::group(['middleware' => ['can:habilitationrendezvous-index']], function () {
        Route::get('habilitationrendezvous', [HabilitationRendezVousController::class, 'index'])->name('habilitationrendezvous');
        Route::get('habilitationrendezvous/index', [HabilitationRendezVousController::class, 'index'])->name('habilitationrendezvous.index');
        Route::get('habilitationrendezvous/calendar-events', [HabilitationRendezVousController::class, 'fetchEvents'])->name('habilitationrendezvous.calendarevents');
        Route::post('habilitationrendezvous/{id}/update/visite', [HabilitationRendezVousController::class, 'updatevisite'])->name('habilitationrendezvous.updatevisite');
        Route::get('habilitationrendezvous/calendar-events/get-event-data/{id}', [HabilitationRendezVousController::class, 'fetchEventsID'])->name('habilitationrendezvous.calendarevents');


    });
    Route::group(['middleware' => ['can:traitementdemandehabilitation-index']], function () {
/*         Route::resources([
            'traitementdemandehabilitation' => TraitementDemandeHabilitationController::class,
        ]); */

        Route::get('traitementdemandehabilitation/{id}/delete', [TraitementDemandeHabilitationController::class, 'delete'])->name('traitementdemandehabilitation.delete');
        Route::get('traitementdemandehabilitation/{id}/{id1}/edit', [TraitementDemandeHabilitationController::class, 'edit'])->name('traitementdemandehabilitation.edit');
        Route::put('traitementdemandehabilitation/{id}/{id1}/update', [TraitementDemandeHabilitationController::class, 'update'])->name('traitementdemandehabilitation.update');
        Route::post('traitementdemandehabilitation/{id}/update/visite', [TraitementDemandeHabilitationController::class, 'updatevisite'])->name('traitementdemandehabilitation.updatevisite');
        Route::get('traitementdemandehabilitation/index', [TraitementDemandeHabilitationController::class, 'index'])->name('traitementdemandehabilitation.index');
        Route::get('traitementdemandehabilitation/calendar-events', [TraitementDemandeHabilitationController::class, 'fetchEvents'])->name('traitementdemandehabilitation.calendarevents');
        Route::get('traitementdemandehabilitation/calendar-events/get-event-data/{id}', [TraitementDemandeHabilitationController::class, 'fetchEventsID'])->name('traitementdemandehabilitation.calendarevents');
        Route::get('traitementdemandehabilitation', [TraitementDemandeHabilitationController::class, 'index'])->name('traitementdemandehabilitation');
        Route::get('traitementdemandehabilitation/create', [TraitementDemandeHabilitationController::class, 'create'])->name('traitementdemandehabilitation.create');
        Route::post('traitementdemandehabilitation/store', [TraitementDemandeHabilitationController::class, 'store'])->name('traitementdemandehabilitation.store');
        Route::post('traitementdemandehabilitation/{id}/store/visite', [TraitementDemandeHabilitationController::class, 'storevisite'])->name('traitementdemandehabilitation.storevisite');
        Route::post('traitementdemandehabilitation/{id}/rapport/visite', [TraitementDemandeHabilitationController::class, 'rapportvisite'])->name('traitementdemandehabilitation.rapportvisite');
        Route::get('traitementdemandehabilitation/{id}/show', [TraitementDemandeHabilitationController::class, 'show'])->name('traitementdemandehabilitation.show');
        Route::get('traitementdemandehabilitation/{id}/delete', [TraitementDemandeHabilitationController::class, 'delete'])->name('traitementdemandehabilitation.delete');
        Route::get('traitementdemandehabilitation/{id}/deleteapf', [TraitementDemandeHabilitationController::class, 'deleteadh'])->name('traitementdemandehabilitation.deleteadh');
    });

    Route::get('traitementdemandehabilitation/{id}/informationaction', [TraitementDemandeHabilitationController::class, 'informationaction'])->name('traitementdemandehabilitation.informationaction');
    Route::get('traitementdemandehabilitation/{id}/informationbeneficiaireaction', [TraitementDemandeHabilitationController::class, 'informationbeneficiaireformation'])->name('traitementdemandehabilitation.informationbeneficiaireaction');
    Route::post('traitementdemandehabilitation/{id}/update/action/formation', [TraitementDemandeHabilitationController::class, 'traitementactionformation'])->name('traitementdemandehabilitation.action.formation');
    Route::post('traitementdemandehabilitation/{id}/update/beneficiaire/action/formation', [TraitementDemandeHabilitationController::class, 'traitementactionformationbenefiaire'])->name('traitementdemandehabilitation.beneficiaire.action.formation');


});
