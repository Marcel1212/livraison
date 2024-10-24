<?php

use App\Http\Controllers\Habilitation\AgreementHabilitationController;
use App\Http\Controllers\Habilitation\CtDemandeHabilitationController;
use App\Http\Controllers\Cahiers\CahierAutreDemandeHabilitationController;
use App\Http\Controllers\Cahiers\TraitementCahierAutreDemandeHabilitationController;
use App\Http\Controllers\Habilitation\DemandeHabilitationController;
use App\Http\Controllers\Habilitation\FormateursController;
use App\Http\Controllers\Habilitation\HabilitationRendezVousController;
use App\Http\Controllers\Habilitation\TraitementDemandeHabilitationController;
use App\Http\Controllers\Habilitation\TraitementAutreDemandeHabilitationFormation;
use App\Http\Controllers\Habilitation\TraitementDemandeHabilitationRejeteController;
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
        Route::get('demandehabilitation/{id}/showle', [DemandeHabilitationController::class, 'showle'])->name('demandehabilitation.showle');
        Route::get('demandehabilitation/{id}/delete', [DemandeHabilitationController::class, 'delete'])->name('demandehabilitation.delete');
        Route::get('demandehabilitation/{id}/deletemoyenpermanente', [DemandeHabilitationController::class, 'deletemoyenpermanente'])->name('demandehabilitation.deletemoyenpermanente');
        Route::get('demandehabilitation/{id}/deleteinterventions', [DemandeHabilitationController::class, 'deleteinterventions'])->name('demandehabilitation.deleteinterventions');
        Route::get('demandehabilitation/{id}/deleteorganisations', [DemandeHabilitationController::class, 'deleteorganisations'])->name('demandehabilitation.deleteorganisations');
        Route::get('demandehabilitation/{id}/deletedomaineDemandeHabilitations', [DemandeHabilitationController::class, 'deletedomaineDemandeHabilitations'])->name('demandehabilitation.deletedomaineDemandeHabilitations');
        Route::get('demandehabilitation/{id}/deleteformateurs', [DemandeHabilitationController::class, 'deleteformateurs'])->name('demandehabilitation.deleteformateurs');
        Route::get('demandehabilitation/{id}/deleteapf', [DemandeHabilitationController::class, 'deleteadh'])->name('demandehabilitation.deleteadh');

        Route::get('demandehabilitation/yancho', [DemandeHabilitationController::class, 'indexyancho'])->name('demandehabilitation');
        Route::get('demandehabilitation/indexyancho', [DemandeHabilitationController::class, 'indexyancho'])->name('demandehabilitation.indexyancho');


        Route::get('demandehabilitation/{id}/{id1}/edityancho', [DemandeHabilitationController::class, 'edityancho'])->name('demandehabilitation.edityancho');




        Route::get('demandehabilitation/{id}/{id1}/editdomaine', [DemandeHabilitationController::class, 'editdomaine'])->name('demandehabilitation.editdomaine');
        Route::post('demandehabilitation/{id}/{id1}/deletedomainestore', [DemandeHabilitationController::class, 'deletedomainestore'])->name('demandehabilitation.deletedomainestore');





        Route::get('demandehabilitation/{id}/deletepieceDemande', [DemandeHabilitationController::class, 'deletepieceDemande'])->name('demandehabilitation.deletepieceDemande');
    });


    Route::group(['middleware' => ['can:traitementsuppressiondomaine-index']], function () {


        Route::get('traitementextensiondomaine/index', [TraitementAutreDemandeHabilitationFormation::class, 'extensiondomaine'])->name('traitementextensiondomaine.index');
        Route::get('traitementextensiondomaine', [TraitementAutreDemandeHabilitationFormation::class, 'extensiondomaine'])->name('traitementextensiondomaine');
        Route::get('traitementextensiondomaine/{id}/{id1}/edit', [TraitementAutreDemandeHabilitationFormation::class, 'extensiondomaineEdit'])->name('traitementextensiondomaine.edit');
        Route::put('traitementextensiondomaine/{id}/update', [TraitementAutreDemandeHabilitationFormation::class, 'extensiondomaineUpdate'])->name('traitementextensiondomaine.update');


//
//        Route::get('traitementdemandehabilitation/create', [TraitementDemandeHabilitationController::class, 'create'])->name('traitementdemandehabilitation.create');
//        Route::post('traitementdemandehabilitation/store', [TraitementDemandeHabilitationController::class, 'store'])->name('traitementdemandehabilitation.store');
//        Route::get('traitementdemandehabilitation/{id}/show', [TraitementDemandeHabilitationController::class, 'show'])->name('traitementdemandehabilitation.show');
//        Route::get('traitementdemandehabilitation/{id}/delete', [TraitementDemandeHabilitationController::class, 'delete'])->name('traitementdemandehabilitation.delete');
//        Route::get('traitementdemandehabilitation/{id}/deleteapf', [TraitementDemandeHabilitationController::class, 'deleteadh'])->name('traitementdemandehabilitation.deleteadh');
    });

    Route::get('traitementdemandehabilitation/indexyancho', [TraitementDemandeHabilitationController::class, 'indexyancho'])->name('traitementdemandehabilitation.indexyancho');


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

    Route::group(['middleware' => ['can:cahierautredemandehabilitation-index']], function () {
        Route::get('cahierautredemandehabilitations', [CahierAutreDemandeHabilitationController::class, 'index'])->name('cahierautredemandehabilitations.index');
        Route::get('cahierautredemandehabilitations/index', [CahierAutreDemandeHabilitationController::class, 'index'])->name('cahierautredemandehabilitations.index');
        Route::get('cahierautredemandehabilitations/create', [CahierAutreDemandeHabilitationController::class, 'create'])->name('cahierautredemandehabilitations.create');
        Route::post('cahierautredemandehabilitations/store', [CahierAutreDemandeHabilitationController::class, 'store'])->name('cahierautredemandehabilitations.store');
        Route::get('cahierautredemandehabilitations/{id}/{id1}/edit', [CahierAutreDemandeHabilitationController::class, 'edit'])->name('cahierautredemandehabilitations.edit');
        Route::put('cahierautredemandehabilitations/{id}/{id1}/update', [CahierAutreDemandeHabilitationController::class, 'update'])->name('cahierautredemandehabilitations.update');
        Route::get('cahierautredemandehabilitations/{id}/notetechnique', [CahierAutreDemandeHabilitationController::class, 'notetechnique'])->name('cahierautredemandehabilitations.notetechnique');
        Route::get('cahierautredemandehabilitations/{id}/{id1}/show', [CahierAutreDemandeHabilitationController::class, 'show'])->name('cahierautredemandehabilitations.show');
        Route::get('cahierautredemandehabilitations/{id}/showformateur', [CahierAutreDemandeHabilitationController::class, 'showformateur'])->name('cahierautredemandehabilitations.showformateur');


    });

    Route::group(['middleware' => ['can:traitementcahierautredemandehabilitation-index']], function () {

        Route::get('traitementcahierautredemandehabilitations', [TraitementCahierAutreDemandeHabilitationController::class, 'index'])->name('traitementcahierautredemandehabilitations.index');
        Route::get('traitementcahierautredemandehabilitations/index', [TraitementCahierAutreDemandeHabilitationController::class, 'index'])->name('traitementcahierautredemandehabilitations.index');
        Route::get('traitementcahierautredemandehabilitations/{id}/{id1}/{id2}/edit', [TraitementCahierAutreDemandeHabilitationController::class, 'edit'])->name('traitementcahierautredemandehabilitations.edit');
        Route::put('traitementcahierautredemandehabilitations/{id}/update', [TraitementCahierAutreDemandeHabilitationController::class, 'update'])->name('traitementcahierautredemandehabilitations.update');
//    Route::get('traitementcahierautredemandehabilitations/{id}/show', [TraitementSuppressionDomaineHabilitationController::class, 'show'])->name('traitementsuppressiondomaine.show');
    });

    Route::group(['middleware' => ['can:ctdemandehabilitation-index']], function () {
        Route::resources([
            'ctdemandehabilitation' => CtDemandeHabilitationController::class,
        ]);

        Route::get('ctdemandehabilitation/{id}/{id2}/edit', [CtDemandeHabilitationController::class, 'edit'])->name('ctdemandehabilitation.editer');
    });

    Route::get('ctdemandehabilitation/{id}/ficheanalyse', [CtDemandeHabilitationController::class, 'ficheanalyse'])->name('ctdemandehabilitation.ficheanalyse');
    Route::get('traitementhabilitationrejete/{id}/ficheanalyse', [TraitementDemandeHabilitationRejeteController::class, 'ficheanalyse'])->name('traitementhabilitationrejete.ficheanalyse');

    Route::group(['middleware' => ['can:traitementhabilitationrejete-index']], function () {
        Route::resources([
            'traitementhabilitationrejete' => TraitementDemandeHabilitationRejeteController::class,
        ]);

        Route::get('traitementhabilitationrejete/{id}/{id1}/edit', [TraitementDemandeHabilitationRejeteController::class, 'edit'])->name('traitementhabilitationrejete.edit');

    });



    Route::group(['middleware' => ['can:agrementhabilitation-index']], function () {
        Route::get('agrementhabilitation', [AgreementHabilitationController::class, 'index'])->name('agrementhabilitation');
        Route::get('agrementhabilitation/index', [AgreementHabilitationController::class, 'index'])->name('agrementhabilitation.index');
        Route::get('agrementhabilitation/{id}/show', [AgreementHabilitationController::class, 'show'])->name('agrementhabilitation.show');

        Route::get('agrementhabilitation/{id}/{id1}/edit', [AgreementHabilitationController::class, 'edit'])->name('agrementhabilitation.edit');
        Route::get('agrementhabilitation/{id}/extensiondomaineformation', [AgreementHabilitationController::class, 'extensiondomaineformation'])->name('agrementhabilitation.extensiondomaineformation');
        Route::post('agrementhabilitation/{id}/{id1}/extensiondomaineformationstore', [AgreementHabilitationController::class, 'extensiondomaineformationstore'])->name('agrementhabilitation.extensiondomaineformationstore');
        Route::get('agrementhabilitation/{id}/{id1}/{id2}/extensiondomaineformationedit', [AgreementHabilitationController::class, 'extensiondomaineformationedit'])->name('agrementhabilitation.extensiondomaineformationedit');
        Route::post('agrementhabilitation/{id}/{id1}/{id2}/extensiondomaineformationupdate', [AgreementHabilitationController::class, 'extensiondomaineformationupdate'])->name('agrementhabilitation.extensiondomaineformationupdate');
        Route::get('agrementhabilitation/{id}/{id1}/{id2}/deletedomaineDemandeExtension', [AgreementHabilitationController::class, 'deletedomaineDemandeExtension'])->name('agrementhabilitation.deletedomaineDemandeExtension');
        Route::get('agrementhabilitation/{id}/{id1}/{id2}/deleteformateursDemandeExtension', [AgreementHabilitationController::class, 'deleteformateursDemandeExtension'])->name('agrementhabilitation.deleteformateursDemandeExtension');


        Route::get('agrementhabilitation/{id}/suppressiondomaineformation', [AgreementHabilitationController::class, 'suppressiondomaineformation'])->name('agrementhabilitation.suppressiondomaineformation');
        Route::post('agrementhabilitation/{id}/{id1}/suppressiondomaineformationstore', [AgreementHabilitationController::class, 'suppressiondomaineformationstore'])->name('agrementhabilitation.suppressiondomaineformationstore');
        Route::get('agrementhabilitation/{id}/{id1}/{id2}/suppressiondomaineformationedit', [AgreementHabilitationController::class, 'suppressiondomaineformationedit'])->name('agrementhabilitation.suppressiondomaineformationedit');
        Route::post('agrementhabilitation/{id}/{id1}/{id2}/suppressiondomaineformationupdate', [AgreementHabilitationController::class, 'suppressiondomaineformationupdate'])->name('agrementhabilitation.suppressiondomaineformationupdate');
        Route::get('agrementhabilitation/{id}/showformateur', [AgreementHabilitationController::class, 'showformateur'])->name('agrementhabilitation.showformateur');
    });


    Route::group(['middleware' => ['can:traitementautredemandehabilitation-index']], function () {
        Route::get('traitementautredemandehabilitation/index', [TraitementAutreDemandeHabilitationFormation::class, 'index'])->name('traitementautredemandehabilitation.index');
        Route::get('traitementautredemandehabilitation', [TraitementAutreDemandeHabilitationFormation::class, 'index'])->name('traitementautredemandehabilitation');
        Route::get('traitementautredemandehabilitation/{id}/{id1}/edit', [TraitementAutreDemandeHabilitationFormation::class, 'edit'])->name('traitementautredemandehabilitation.edit');
        Route::put('traitementautredemandehabilitation/{id}/update', [TraitementAutreDemandeHabilitationFormation::class, 'update'])->name('traitementautredemandehabilitation.update');


        Route::get('traitementautredemandehabilitation/{id}/{id1}/editExtension', [TraitementAutreDemandeHabilitationFormation::class, 'extensiondomaineEdit'])->name('traitementautredemandehabilitation.editExtension');
        Route::put('traitementautredemandehabilitation/{id}/{id1}/updateExtension', [TraitementAutreDemandeHabilitationFormation::class, 'updateExtension'])->name('traitementautredemandehabilitation.updateExtension');


        Route::get('traitementautredemandehabilitation/affectation', [TraitementAutreDemandeHabilitationFormation::class, 'affectation'])->name('traitementautredemandehabilitation.affectation');
        Route::get('traitementautredemandehabilitation/{id}/{id1}/editaffectation', [TraitementAutreDemandeHabilitationFormation::class, 'editaffectation'])->name('traitementautredemandehabilitation.editaffectation');
        Route::put('traitementautredemandehabilitation/{id}/updateaffectation', [TraitementAutreDemandeHabilitationFormation::class, 'updateaffectation'])->name('traitementautredemandehabilitation.updateaffectation');
        Route::get('traitementautredemandehabilitation/{id}/show', [TraitementAutreDemandeHabilitationFormation::class, 'show'])->name('traitementautredemandehabilitation.show');

        Route::get('traitementautredemandehabilitation/{id}/{id1}/editaffectationExtension', [TraitementAutreDemandeHabilitationFormation::class, 'editaffectationExtension'])->name('traitementautredemandehabilitation.editaffectationExtension');
        Route::put('traitementautredemandehabilitation/{id}/updateaffectationExtension', [TraitementAutreDemandeHabilitationFormation::class, 'updateaffectationExtension'])->name('traitementautredemandehabilitation.updateaffectationExtension');



    });





});
