<?php

use App\Http\Controllers\Habilitation\DemandeHabilitationController;
use App\Http\Controllers\Habilitation\FormateursController;
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
        Route::get('demandehabilitation/{id}/deletemoyenpermanente', [DemandeHabilitationController::class, 'deletemoyenpermanente'])->name('demandehabilitation.deletemoyenpermanente');
        Route::get('demandehabilitation/{id}/deleteinterventions', [DemandeHabilitationController::class, 'deleteinterventions'])->name('demandehabilitation.deleteinterventions');
        Route::get('demandehabilitation/{id}/deleteorganisations', [DemandeHabilitationController::class, 'deleteorganisations'])->name('demandehabilitation.deleteorganisations');
        Route::get('demandehabilitation/{id}/deletedomaineDemandeHabilitations', [DemandeHabilitationController::class, 'deletedomaineDemandeHabilitations'])->name('demandehabilitation.deletedomaineDemandeHabilitations');
        Route::get('demandehabilitation/{id}/deleteformateurs', [DemandeHabilitationController::class, 'deleteformateurs'])->name('demandehabilitation.deleteformateurs');
        Route::get('demandehabilitation/{id}/deleteapf', [DemandeHabilitationController::class, 'deleteadh'])->name('demandehabilitation.deleteadh');
        Route::get('demandehabilitation/{id}/deletepieceDemande', [DemandeHabilitationController::class, 'deletepieceDemande'])->name('demandehabilitation.deletepieceDemande');
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
        Route::get('traitementdemandehabilitation/{id}/rapport', [TraitementDemandeHabilitationController::class, 'rapport'])->name('traitementdemandehabilitation.rapport');
        Route::get('traitementdemandehabilitation/{id}/delete', [TraitementDemandeHabilitationController::class, 'delete'])->name('traitementdemandehabilitation.delete');
        Route::get('traitementdemandehabilitation/{id}/deleteapf', [TraitementDemandeHabilitationController::class, 'deleteadh'])->name('traitementdemandehabilitation.deleteadh');
    });

    Route::get('traitementdemandehabilitation/{id}/informationaction', [TraitementDemandeHabilitationController::class, 'informationaction'])->name('traitementdemandehabilitation.informationaction');
    Route::get('traitementdemandehabilitation/{id}/informationbeneficiaireaction', [TraitementDemandeHabilitationController::class, 'informationbeneficiaireformation'])->name('traitementdemandehabilitation.informationbeneficiaireaction');
    Route::post('traitementdemandehabilitation/{id}/update/action/formation', [TraitementDemandeHabilitationController::class, 'traitementactionformation'])->name('traitementdemandehabilitation.action.formation');
    Route::post('traitementdemandehabilitation/{id}/update/beneficiaire/action/formation', [TraitementDemandeHabilitationController::class, 'traitementactionformationbenefiaire'])->name('traitementdemandehabilitation.beneficiaire.action.formation');


    Route::group(['middleware' => ['can:formateurs-index']], function () {
        Route::get('formateurs', [FormateursController::class, 'index'])->name('formateurs');
        Route::get('formateurs/index', [FormateursController::class, 'index'])->name('formateurs.index');
        Route::get('formateurs/create', [FormateursController::class, 'create'])->name('formateurs.create');
        Route::post('formateurs/store', [FormateursController::class, 'store'])->name('formateurs.store');
        Route::get('formateurs/{id}/{id1}/edit', [FormateursController::class, 'edit'])->name('formateurs.edit');
        Route::put('formateurs/{id}/{id1}/update', [FormateursController::class, 'update'])->name('formateurs.update');
        Route::get('formateurs/{id}/delete', [FormateursController::class, 'delete'])->name('formateurs.delete');
        Route::get('formateurs/{id}/deleteformation', [FormateursController::class, 'deleteformation'])->name('formateurs.deleteformation');
        Route::get('formateurs/{id}/deleteexperience', [FormateursController::class, 'deleteexperience'])->name('formateurs.deleteexperience');
        Route::get('formateurs/{id}/deletecompetence', [FormateursController::class, 'deletecompetence'])->name('formateurs.deletecompetence');
        Route::get('formateurs/{id}/deletelangue', [FormateursController::class, 'deletelangue'])->name('formateurs.deletelangue');
        Route::get('formateurs/{id}/deletepieceformateur', [FormateursController::class, 'deletepieceformateur'])->name('formateurs.deletepieceformateur');
        Route::get('formateurs/{id}/show', [FormateursController::class, 'show'])->name('formateurs.show');

    });

});
