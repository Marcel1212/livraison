<?php

use App\Http\Controllers\PlanFormation\CtplanformationvaliderController;
use App\Http\Controllers\PlanFormation\ComitePleniereController;
use App\Http\Controllers\PlanFormation\AjaxController;
use App\Http\Controllers\PlanFormation\ListeLierController;
use App\Http\Controllers\PlanFormation\PlanFormationController;
use App\Http\Controllers\PlanFormation\ComitePermanenteController;
use App\Http\Controllers\PlanFormation\CahierplanformationController;
use App\Http\Controllers\PlanFormation\TratementPlanFormationController;
use App\Http\Controllers\PlanFormation\CtplanformationController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth']], function () {

    Route::resources([
		'ctplanformationvalider' => CtplanformationvaliderController::class,
         ]);

    Route::group(['middleware' => ['can:ctplanformationpleniere-index']], function () {
    Route::get('ctplanformationpleniere/{id}/{id1}/edit', [ComitePleniereController::class, 'edit'])->name('ctplanformationpleniere.edit');
    Route::put('ctplanformationpleniere/{id}/{id1}/update', [ComitePleniereController::class, 'update'])->name('ctplanformationpleniere.update');
    Route::get('ctplanformationpleniere/index', [ComitePleniereController::class, 'index'])->name('ctplanformationpleniere.index');
    Route::get('ctplanformationpleniere', [ComitePleniereController::class, 'index'])->name('ctplanformationpleniere');
    Route::get('ctplanformationpleniere/create', [ComitePleniereController::class, 'create'])->name('ctplanformationpleniere.create');
    Route::post('ctplanformationpleniere/store', [ComitePleniereController::class, 'store'])->name('ctplanformationpleniere.store');
    Route::get('ctplanformationpleniere/{id}/show', [ComitePleniereController::class, 'show'])->name('ctplanformationpleniere.show');
    Route::get('ctplanformationpleniere/{id}/delete', [ComitePleniereController::class, 'delete'])->name('ctplanformationpleniere.delete');
    Route::get('ctplanformationpleniere/{id}/{id2}/{id3}/cahier', [ComitePleniereController::class, 'cahier'])->name('ctplanformationpleniere.cahier');
    Route::get('ctplanformationpleniere/{id}/{id2}/{id3}/editer', [ComitePleniereController::class, 'editer'])->name('ctplanformationpleniere.editer');
    Route::post('ctplanformationpleniere/{id}/{id2}/{id3}/cahierupdate', [ComitePleniereController::class, 'cahierupdate'])->name('ctplanformationpleniere.cahierupdate');
	});

	Route::get('comitepleniere/{id}/deletecomitepleniereprojetetude', [ComitePleniereController::class, 'delete'])->name('comitepleniere.delete');
    Route::get('comitepleniere/{id}/{id2}/cahier', [ComitePleniereController::class, 'cahier'])->name('comitepleniere.cahier');
    Route::get('comitepleniere/{id}/{id2}/editer', [ComitePleniereController::class, 'editer'])->name('comitepleniere.editer');
    Route::post('comitepleniere/{id}/{id2}/cahierupdate', [ComitePleniereController::class, 'cahierupdate'])->name('comitepleniere.cahierupdate');

    Route::post('ajoutcabinetetrangere', [AjaxController::class, 'ajoutcabinetetrangere'])->name('ajoutcabinetetrangere');
    Route::get('/entrepriseinterneplan', [ListeLierController::class, 'getEntrepriseinterneplan']);
    Route::get('/entrepriseinterneplanGeneral/{id}', [ListeLierController::class, 'getEntrepriseinterneplanGeneral']);

    Route::get('/listedepartement', [ListeLierController::class, 'getDepartement']);
    Route::get('/listeagencedepartement/{id}', [ListeLierController::class, 'getAgenceDepartement']);
    Route::get('/entreprisecabinetformation', [ListeLierController::class, 'getEntreprisecabinetformation']);
    Route::get('/domaineformation/{id}', [ListeLierController::class, 'getDomaineFormation']);
    Route::get('/domaineformation/{id}/listformation', [ListeLierController::class, 'getDomaineFormation']);
    Route::get('/domaineformations', [ListeLierController::class, 'getDomaineFormations']);
    Route::get('/entreprisecabinetetrangerformation', [ListeLierController::class, 'getEntreprisecabinetetrangerformation']);
    Route::get('/entreprisecabinetetrangerformationmax', [ListeLierController::class, 'getEntreprisecabinetetrangerformationmax']);
    Route::get('/caracteristiqueTypeFormationlist/{id}', [ListeLierController::class, 'getCaracteristiqueTypeFormation']);
    Route::get('/departementlist/{id}', [ListeLierController::class, 'getDepartements']);
    Route::get('/servicelist/{id}', [ListeLierController::class, 'getServices']);

		Route::group(['middleware' => ['can:planformation-index']], function () {
        Route::get('planformation/{id}/delete', [PlanFormationController::class, 'delete'])->name('planformation.delete');
        Route::get('planformation/{id}/{id1}/edit', [PlanFormationController::class, 'edit'])->name('planformation.edit');
        Route::put('planformation/{id}/{id1}/update', [PlanFormationController::class, 'update'])->name('planformation.update');
        Route::get('planformation/index', [PlanFormationController::class, 'index'])->name('planformation.index');
        Route::get('planformation', [PlanFormationController::class, 'index'])->name('planformation');
        Route::get('planformation/create', [PlanFormationController::class, 'create'])->name('planformation.create');
        Route::post('planformation/store', [PlanFormationController::class, 'store'])->name('planformation.store');
        Route::get('planformation/{id}/show', [PlanFormationController::class, 'show'])->name('planformation.show');
        Route::get('planformation/{id}/deleteapf', [PlanFormationController::class, 'deleteapf'])->name('planformation.deleteapf');
			});

	    /*Route::group(['middleware' => ['can:cotisation-index']], function () {
        Route::get('cotisation', [CotisationController::class, 'index'])->name('cotisation');
        Route::get('cotisation/index', [CotisationController::class, 'index'])->name('cotisation.index');
        Route::get('cotisation/create', [CotisationController::class, 'create'])->name('cotisation.create');
        Route::post('cotisation/store', [CotisationController::class, 'store'])->name('cotisation.store');
        Route::get('cotisation/{id}/show', [CotisationController::class, 'show'])->name('cotisation.show');
		});*/

    Route::group(['middleware' => ['can:comitepermanente-index']], function () {
        Route::get('comitepermanente/{id}/delete', [ComitePermanenteController::class, 'delete'])->name('comitepermanente.delete');
        Route::get('comitepermanente/{id}/{id1}/edit', [ComitePermanenteController::class, 'edit'])->name('comitepermanente.edit');
        Route::put('comitepermanente/{id}/{id1}/update', [ComitePermanenteController::class, 'update'])->name('comitepermanente.update');
        Route::get('comitepermanente/index', [ComitePermanenteController::class, 'index'])->name('comitepermanente.index');
        Route::get('comitepermanente', [ComitePermanenteController::class, 'index'])->name('comitepermanente');
        Route::get('comitepermanente/create', [ComitePermanenteController::class, 'create'])->name('comitepermanente.create');
        Route::post('comitepermanente/store', [ComitePermanenteController::class, 'store'])->name('comitepermanente.store');
        Route::get('comitepermanente/{id}/show', [ComitePermanenteController::class, 'show'])->name('comitepermanente.show');
        Route::get('comitepermanente/{id}/{id2}/agrement', [ComitePermanenteController::class, 'agrement'])->name('comitepermanente.agrement');
        Route::get('comitepermanente/{id}/{id2}/{id3}/editer', [ComitePermanenteController::class, 'editer'])->name('comitepermanente.editer');
        Route::post('comitepermanente/{id}/{id2}/{id3}/agrementupdate', [ComitePermanenteController::class, 'agrementupdate'])->name('comitepermanente.agrementupdate');
    });


    Route::get('cahierplanformation/{id}/delete', [CahierplanformationController::class, 'delete'])->name('cahierplanformation.delete');
    Route::get('cahierplanformation/{id}/{id1}/edit', [CahierplanformationController::class, 'edit'])->name('cahierplanformation.edit');
    Route::put('cahierplanformation/{id}/{id1}/update', [CahierplanformationController::class, 'update'])->name('cahierplanformation.update');
    Route::get('cahierplanformation/index', [CahierplanformationController::class, 'index'])->name('cahierplanformation.index');
    Route::get('cahierplanformation', [CahierplanformationController::class, 'index'])->name('cahierplanformation');
    Route::get('cahierplanformation/create', [CahierplanformationController::class, 'create'])->name('cahierplanformation.create');
    Route::post('cahierplanformation/store', [CahierplanformationController::class, 'store'])->name('cahierplanformation.store');
    Route::get('cahierplanformation/{id}/show', [CahierplanformationController::class, 'show'])->name('cahierplanformation.show');
    Route::get('cahierplanformation/{id}/etat', [CahierplanformationController::class, 'etat'])->name('cahierplanformation.etat');
    Route::get('cahierplanformation/{id}/{id2}/agrement', [CahierplanformationController::class, 'agrement'])->name('cahierplanformation.agrement');
    Route::get('cahierplanformation/{id}/{id2}/{id3}/editer', [CahierplanformationController::class, 'editer'])->name('cahierplanformation.editer');
    Route::post('cahierplanformation/{id}/{id2}/{id3}/agrementupdate', [CahierplanformationController::class, 'agrementupdate'])->name('cahierplanformation.agrementupdate');

    Route::get('planformation/{id}/deleteapf', [PlanFormationController::class, 'deleteapf'])->name('planformation.deleteapf');

    Route::get('ctplanformationvalider/{id}/{id2}/editer', [CtplanformationvaliderController::class, 'editer'])->name('ctplanformationvalider.editer');

    Route::group(['middleware' => ['can:traitementplanformation-index']], function () {
        Route::resources([
            'traitementplanformation' => TratementPlanFormationController::class,
        ]);
    });

    Route::get('traitementplanformation/{id}/informationaction', [TratementPlanFormationController::class, 'informationaction'])->name('traitementplanformation.informationaction');
    Route::get('traitementplanformation/{id}/informationbeneficiaireaction', [TratementPlanFormationController::class, 'informationbeneficiaireformation'])->name('traitementplanformation.informationbeneficiaireaction');
    Route::post('traitementplanformation/{id}/update/action/formation', [TratementPlanFormationController::class, 'traitementactionformation'])->name('traitementplanformation.action.formation');
    Route::post('traitementplanformation/{id}/update/beneficiaire/action/formation', [TratementPlanFormationController::class, 'traitementactionformationbenefiaire'])->name('traitementplanformation.beneficiaire.action.formation');

    Route::group(['middleware' => ['can:ctplanformation-index']], function () {
        Route::resources([
            'ctplanformation' => CtplanformationController::class,
        ]);
    });

});
