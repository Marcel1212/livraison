<?php

use App\Http\Controllers\AgreementController;
use App\Http\Controllers\DemandeAnnulationActionPlanController;
use App\Http\Controllers\MotDePasseOublieController;
use App\Http\Controllers\SelectionOperateurProjetEtudeController;
use App\Http\Controllers\TraitementSelectionOperateurProjetEtudeController;
use Illuminate\Support\Facades\Route;

Route::get('/reload-captcha', [App\Http\Controllers\ConnexionController::class, 'reloadCaptcha'])->name('reloadCaptcha');

Route::match(['get', 'post'], '/', [App\Http\Controllers\IndexController::class, 'index'])->name('/');
Route::match(['get', 'post'], '/login', [App\Http\Controllers\ConnexionController::class, 'login'])->name('login');
Route::match(['get', 'post'], '/enrolements', [App\Http\Controllers\EnrolementController::class, 'create'])->name('enrolements');
Route::match(['get', 'post'], '/projetetude', [App\Http\Controllers\ProjetEtudeController::class, 'index'])->name('projetetude.index');
Route::match(['get', 'post'], '/enrolements.store', [App\Http\Controllers\EnrolementController::class, 'store'])->name('enrolements.store');
Route::get('/secteuractivilitelistes/{id}', [App\Http\Controllers\EnrolementController::class, 'getsecteuractivilitelistes']);
//Route::resources(['enrolement' => App\Http\Controllers\EnrolementController::class,]);
Route::match(['get', 'post'], '/connexion', [App\Http\Controllers\ConnexionController::class, 'login'])->name('connexion');
Route::match(['post'], '/test', [App\Http\Controllers\PlanFormationController::class, 'test'])->name('test');
Route::get('/deconnexion', [App\Http\Controllers\HomeController::class, 'deconnexion']);

Route::get('/motdepasseoublie', [MotDePasseOublieController::class, 'index'])->name('motdepasseoublie');
Route::post('/motdepasseoublie', [MotDePasseOublieController::class, 'verify'])->name('motdepasseoublie.verify');

Route::get('motdepasseoublie/{email}/otp', [MotDePasseOublieController::class, 'otp'])->name('otp');
Route::post('motdepasseoublie/{email}/otp', [MotDePasseOublieController::class, 'verifyOtpUpdatePassword'])->name('otp.verification');


//
//Route::get('/reset-password', function(){
//    return view('motdepasseoublie.index');
//});
Route::group(['middleware' => ['auth']], function () {
    //Route::group(['middleware' => ['can:role-index']], function () {
    Route::resources([
        'roles' => App\Http\Controllers\RoleController::class,
        'users' => App\Http\Controllers\UserController::class,
        'permissions' => App\Http\Controllers\PermissionController::class,
        'menus' => App\Http\Controllers\MenuController::class,
        'sousmenus' => App\Http\Controllers\SousmenuController::class,
        'agence' => App\Http\Controllers\AgenceController::class,
        'direction' => App\Http\Controllers\DirectionController::class,
        'departement' => App\Http\Controllers\DepartementController::class,
        'service' => App\Http\Controllers\ServiceController::class,
        'activites' => App\Http\Controllers\ActivitesController::class,
        'centreimpot' => App\Http\Controllers\CentreImpotController::class,
        'localite' => App\Http\Controllers\LocaliteController::class,
        'projetetude' => App\Http\Controllers\ProjetEtudeController::class,
        'projetformation' => App\Http\Controllers\ProjetFormationController::class,
        'enrolement' => App\Http\Controllers\EnrolementController::class,
        'statutoperations' => App\Http\Controllers\StatutOperationController::class,
        'motifs' => App\Http\Controllers\MotifController::class,
        //'planformation' => App\Http\Controllers\PlanFormationController::class,
        'typeentreprise' => App\Http\Controllers\TypeEntrepriseController::class,
        'butformation' => App\Http\Controllers\ButFormationController::class,
        'typeformation' => App\Http\Controllers\TypeFormationController::class,
        'traitementplanformation' => App\Http\Controllers\TratementPlanFormationController::class,
        'periodeexercice' => App\Http\Controllers\PeriodeExerciceController::class,
        'ctplanformation' => App\Http\Controllers\CtplanformationController::class,
        'ctprojetetude' => App\Http\Controllers\CtprojetetudeController::class,
        'ctplanformationvalider' => App\Http\Controllers\CtplanformationvaliderController::class,
        'comitepleniere' => App\Http\Controllers\ComitePleniereController::class,
        'formejuridique' => App\Http\Controllers\FormeJuridiqueController::class,
        'secteuractivite' => App\Http\Controllers\SecteurActiviteController::class,
        'partentreprise' => App\Http\Controllers\PartEntrepriseController::class,
        'typecomites' => App\Http\Controllers\TypeComiteController::class,
//            'agreement' => App\Http\Controllers\AgreementController::class,
        //'comitegestion' => App\Http\Controllers\ComiteGestionController::class,
        //'comitepermanente' => App\Http\Controllers\ComitePermanenteController::class,
    ]);
    //});

//    Route::get('agreement/{id}/cancel', [App\Http\Controllers\AgreementController::class, 'cancel'])->name('agreement.cancel');
//    Route::post('agreement/{id}/cancel/store', [App\Http\Controllers\AgreementController::class, 'cancelStore'])->name('agreement.cancel.store');
    Route::put('agreement/{id_demande}/{id_plan}/cancel/update', [App\Http\Controllers\AgreementController::class, 'cancelUpdate'])->name('agreement.cancel.update');

    //Agrément
    Route::get('agreement', [AgreementController::class, 'index'])->name('agreement');
    Route::get('agreement/index', [AgreementController::class, 'index'])->name('agreement.index');
    Route::get('agreement/{id_plan_de_formation}/{id_etape}/edit', [AgreementController::class, 'edit'])->name('agreement.edit');
    Route::get('agreement/{id_plan_de_formation}/show', [AgreementController::class, 'show'])->name('agreement.show');



    Route::get('agreement/{id_plan_de_formation}/{id_action}/{id_etape}/editaction', [AgreementController::class, 'editaction'])->name('agreement.editaction');


//    /{id_plan_de_formation}/{id_etape}/cancel

    //Demande Annulation Agrément
    Route::post('agreement/{id_plan_de_formation}/{id_etape}/cancel', [AgreementController::class, 'cancel'])->name('agreement.cancel');

//    Route::put('agreement/{id_demande}/{id_plan}/cancel/update', [App\Http\Controllers\AgreementController::class, 'cancelUpdate'])->name('agreement.cancel.update');

    Route::get('agreement/{id_plan}/{id_action}/substitution', [App\Http\Controllers\AgreementController::class, 'substitution'])->name('agreement.substitution');
    Route::post('agreement/{id_plan}/{id_action}/substitution', [App\Http\Controllers\AgreementController::class, 'substitutionsStore'])->name('agreement.substitution');
    Route::put('agreement/{id_plan}/{id_action}/substitution', [App\Http\Controllers\AgreementController::class, 'substitutionsUpdate'])->name('agreement.substitution');
    //    Route::get('comitepermanente/{id}/{id1}/edit', [App\Http\Controllers\ComitePermanenteController::class, 'edit'])->name('comitepermanente.edit');




    //traitement

    Route::get('traitementdemandesubstitutionplan', [App\Http\Controllers\TraitementDemandeSubstitutionPlanController::class, 'index'])->name('traitementdemandesubstitutionplan.index');
    Route::get('traitementdemandesubstitutionplan/{id}/{id2}/edit', [App\Http\Controllers\TraitementDemandeSubstitutionPlanController::class, 'edit'])->name('traitementdemandesubstitutionplan.edit');
    Route::put('traitementdemandesubstitutionplan/{id}/update', [App\Http\Controllers\TraitementDemandeSubstitutionPlanController::class, 'update'])->name('traitementdemandesubstitutionplan.update');


    Route::get('traitementdemandeannulationplan', [App\Http\Controllers\TraitementDemandeAnnulationPlanController::class, 'index'])->name('traitementdemandeannulationplan.index');
    Route::get('traitementdemandeannulationplan/{id}/{id2}/edit', [App\Http\Controllers\TraitementDemandeAnnulationPlanController::class, 'edit'])->name('traitementdemandeannulationplan.edit');
    Route::put('traitementdemandeannulationplan/{id}/update', [App\Http\Controllers\TraitementDemandeAnnulationPlanController::class, 'update'])->name('traitementdemandeannulationplan.update');


    //Sélection opérateur pour projet d'étude
    Route::get('selectionoperateurprojetetude', [SelectionOperateurProjetEtudeController::class, 'index'])->name('selectionoperateurprojetetude.index');
    Route::get('selectionoperateurprojetetude/{id_projet_etude}/edit', [SelectionOperateurProjetEtudeController::class, 'edit'])->name('selectionoperateurprojetetude.edit');
    Route::post('selectionoperateurprojetetude/{id_projet_etude}/update', [SelectionOperateurProjetEtudeController::class, 'update'])->name('selectionoperateurprojetetude.update');
    Route::put('selectionoperateurprojetetude/{id_projet_etude}/mark', [SelectionOperateurProjetEtudeController::class, 'mark'])->name('selectionoperateurprojetetude.mark');

    //
    Route::get('traitementselectionoperateurprojetetude', [TraitementSelectionOperateurProjetEtudeController::class, 'index'])->name('traitementselectionoperateurprojetetude.index');
    Route::get('traitementselectionoperateurprojetetude/{id_projet_etude}/{id_combi_proc}/edit', [TraitementSelectionOperateurProjetEtudeController::class, 'edit'])->name('traitementselectionoperateurprojetetude.edit');
    Route::put('traitementselectionoperateurprojetetude/{id_projet_etude}/update', [TraitementSelectionOperateurProjetEtudeController::class, 'update'])->name('traitementselectionoperateurprojetetude.update');



    Route::get('comitepleniere/{id}/delete', [App\Http\Controllers\ComitePleniereController::class, 'delete'])->name('comitepleniere.delete');
    Route::get('comitepleniere/{id}/{id2}/cahier', [App\Http\Controllers\ComitePleniereController::class, 'cahier'])->name('comitepleniere.cahier');
    Route::get('comitepleniere/{id}/{id2}/editer', [App\Http\Controllers\ComitePleniereController::class, 'editer'])->name('comitepleniere.editer');
    Route::post('comitepleniere/{id}/{id2}/cahierupdate', [App\Http\Controllers\ComitePleniereController::class, 'cahierupdate'])->name('comitepleniere.cahierupdate');

    Route::post('ajoutcabinetetrangere', [App\Http\Controllers\AjaxController::class, 'ajoutcabinetetrangere'])->name('ajoutcabinetetrangere');

    Route::get('/entrepriseinterneplan', [App\Http\Controllers\ListeLierController::class, 'getEntrepriseinterneplan']);
    Route::get('/entreprisecabinetformation', [App\Http\Controllers\ListeLierController::class, 'getEntreprisecabinetformation']);
    Route::get('/entreprisecabinetetrangerformation', [App\Http\Controllers\ListeLierController::class, 'getEntreprisecabinetetrangerformation']);
    Route::get('/entreprisecabinetetrangerformationmax', [App\Http\Controllers\ListeLierController::class, 'getEntreprisecabinetetrangerformationmax']);
    Route::get('/departementlist/{id}', [App\Http\Controllers\ListeLierController::class, 'getDepartements']);
    Route::get('/servicelist/{id}', [App\Http\Controllers\ListeLierController::class, 'getServices']);
    Route::get('planformation/{id}/delete', [App\Http\Controllers\PlanFormationController::class, 'delete'])->name('planformation.delete');
    Route::get('planformation/{id}/{id1}/edit', [App\Http\Controllers\PlanFormationController::class, 'edit'])->name('planformation.edit');
    Route::put('planformation/{id}/{id1}/update', [App\Http\Controllers\PlanFormationController::class, 'update'])->name('planformation.update');
    Route::get('planformation/index', [App\Http\Controllers\PlanFormationController::class, 'index'])->name('planformation.index');
    Route::get('planformation', [App\Http\Controllers\PlanFormationController::class, 'index'])->name('planformation');
    Route::get('planformation/create', [App\Http\Controllers\PlanFormationController::class, 'create'])->name('planformation.create');
    Route::post('planformation/store', [App\Http\Controllers\PlanFormationController::class, 'store'])->name('planformation.store');
    Route::get('planformation/{id}/show', [App\Http\Controllers\PlanFormationController::class, 'show'])->name('planformation.show');

    Route::get('comitegestion/{id}/delete', [App\Http\Controllers\ComiteGestionController::class, 'delete'])->name('comitegestion.delete');
    Route::get('comitegestion/{id}/{id1}/edit', [App\Http\Controllers\ComiteGestionController::class, 'edit'])->name('comitegestion.edit');
    Route::put('comitegestion/{id}/{id1}/update', [App\Http\Controllers\ComiteGestionController::class, 'update'])->name('comitegestion.update');
    Route::get('comitegestion/index', [App\Http\Controllers\ComiteGestionController::class, 'index'])->name('comitegestion.index');
    Route::get('comitegestion', [App\Http\Controllers\ComiteGestionController::class, 'index'])->name('comitegestion');
    Route::get('comitegestion/create', [App\Http\Controllers\ComiteGestionController::class, 'create'])->name('comitegestion.create');
    Route::post('comitegestion/store', [App\Http\Controllers\ComiteGestionController::class, 'store'])->name('comitegestion.store');
    Route::get('comitegestion/{id}/show', [App\Http\Controllers\ComiteGestionController::class, 'show'])->name('comitegestion.show');
    Route::get('comitegestion/{id}/{id2}/agrement', [App\Http\Controllers\ComiteGestionController::class, 'agrement'])->name('comitegestion.agrement');
    Route::get('comitegestion/{id}/{id2}/{id3}/editer', [App\Http\Controllers\ComiteGestionController::class, 'editer'])->name('comitegestion.editer');
    Route::post('comitegestion/{id}/{id2}/{id3}/agrementupdate', [App\Http\Controllers\ComiteGestionController::class, 'agrementupdate'])->name('comitegestion.agrementupdate');

    Route::get('comitepermanente/{id}/delete', [App\Http\Controllers\ComitePermanenteController::class, 'delete'])->name('comitepermanente.delete');
    Route::get('comitepermanente/{id}/{id1}/edit', [App\Http\Controllers\ComitePermanenteController::class, 'edit'])->name('comitepermanente.edit');
    Route::put('comitepermanente/{id}/{id1}/update', [App\Http\Controllers\ComitePermanenteController::class, 'update'])->name('comitepermanente.update');
    Route::get('comitepermanente/index', [App\Http\Controllers\ComitePermanenteController::class, 'index'])->name('comitepermanente.index');
    Route::get('comitepermanente', [App\Http\Controllers\ComitePermanenteController::class, 'index'])->name('comitepermanente');
    Route::get('comitepermanente/create', [App\Http\Controllers\ComitePermanenteController::class, 'create'])->name('comitepermanente.create');
    Route::post('comitepermanente/store', [App\Http\Controllers\ComitePermanenteController::class, 'store'])->name('comitepermanente.store');
    Route::get('comitepermanente/{id}/show', [App\Http\Controllers\ComitePermanenteController::class, 'show'])->name('comitepermanente.show');
    Route::get('comitepermanente/{id}/{id2}/agrement', [App\Http\Controllers\ComitePermanenteController::class, 'agrement'])->name('comitepermanente.agrement');
    Route::get('comitepermanente/{id}/{id2}/{id3}/editer', [App\Http\Controllers\ComitePermanenteController::class, 'editer'])->name('comitepermanente.editer');
    Route::post('comitepermanente/{id}/{id2}/{id3}/agrementupdate', [App\Http\Controllers\ComitePermanenteController::class, 'agrementupdate'])->name('comitepermanente.agrementupdate');

    Route::get('cahierplanformation/{id}/delete', [App\Http\Controllers\CahierplanformationController::class, 'delete'])->name('cahierplanformation.delete');
    Route::get('cahierplanformation/{id}/{id1}/edit', [App\Http\Controllers\CahierplanformationController::class, 'edit'])->name('cahierplanformation.edit');
    Route::put('cahierplanformation/{id}/{id1}/update', [App\Http\Controllers\CahierplanformationController::class, 'update'])->name('cahierplanformation.update');
    Route::get('cahierplanformation/index', [App\Http\Controllers\CahierplanformationController::class, 'index'])->name('cahierplanformation.index');
    Route::get('cahierplanformation', [App\Http\Controllers\CahierplanformationController::class, 'index'])->name('cahierplanformation');
    Route::get('cahierplanformation/create', [App\Http\Controllers\CahierplanformationController::class, 'create'])->name('cahierplanformation.create');
    Route::post('cahierplanformation/store', [App\Http\Controllers\CahierplanformationController::class, 'store'])->name('cahierplanformation.store');
    Route::get('cahierplanformation/{id}/show', [App\Http\Controllers\CahierplanformationController::class, 'show'])->name('cahierplanformation.show');
    Route::get('cahierplanformation/{id}/etat', [App\Http\Controllers\CahierplanformationController::class, 'etat'])->name('cahierplanformation.etat');
    Route::get('cahierplanformation/{id}/{id2}/agrement', [App\Http\Controllers\CahierplanformationController::class, 'agrement'])->name('cahierplanformation.agrement');
    Route::get('cahierplanformation/{id}/{id2}/{id3}/editer', [App\Http\Controllers\CahierplanformationController::class, 'editer'])->name('cahierplanformation.editer');
    Route::post('cahierplanformation/{id}/{id2}/{id3}/agrementupdate', [App\Http\Controllers\CahierplanformationController::class, 'agrementupdate'])->name('cahierplanformation.agrementupdate');


    Route::get('planformation/{id}/deleteapf', [App\Http\Controllers\PlanFormationController::class, 'deleteapf'])->name('planformation.deleteapf');
    Route::get('ctplanformationvalider/{id}/{id2}/editer', [App\Http\Controllers\CtplanformationvaliderController::class, 'editer'])->name('ctplanformationvalider.editer');
    Route::get('agence/{id}/delete', [App\Http\Controllers\AgenceController::class, 'delete'])->name('agence.delete');
    Route::get('users/{id}/delete', [App\Http\Controllers\UserController::class, 'delete'])->name('users.delete');
    Route::get('/dashboard', [App\Http\Controllers\ConnexionController::class, 'dashboard'])->name('dashboard');
    Route::match(['get', 'post'], '/menuprofil', [App\Http\Controllers\GenerermenuController::class, 'parametragemenu'])->name('menuprofil');
    Route::match(['get', 'post'], '/profil', [App\Http\Controllers\HomeController::class, 'profil'])->name('profil');


    Route::match(['get', 'post'], '/menuprofillayout/{id}', [App\Http\Controllers\GenerermenuController::class, 'menuprofillayout'])->name('menuprofillayout');



    Route::match(['get', 'post'], '/modifiermotdepasse', [App\Http\Controllers\HomeController::class, 'updatepassword'])->name('modifier.mot.passe');
    Route::match(['get', 'post'], '/deleteactiviteentreprise/{id}', [App\Http\Controllers\HomeController::class, 'deleteactiviteentreprise'])->name('deleteactiviteentreprise');



    Route::group(['middleware' => ['can:role-index']], function () {
        Route::match(['get', 'post'], '/parametresysteme', [App\Http\Controllers\ParametreController::class, 'parametresysteme'])->name('parametresysteme');
        Route::match(['get', 'post'], '/creerparametresysteme', [App\Http\Controllers\ParametreController::class, 'creerparametresysteme'])->name('creerparametresysteme');
        Route::match(['get', 'post'], '/projetetudesoumettre/{id}', [App\Http\Controllers\ProjetEtudeController::class, 'projetetudesoumettre'])->name('projetetudesoumettre');
        Route::match(['get', 'post'], '/modifierparametresysteme/{id}', [App\Http\Controllers\ParametreController::class, 'modifierparametresysteme'])->name('modifierparametresysteme');
        Route::match(['get', 'post'], '/activeparametresysteme/{id}/{id1}', [App\Http\Controllers\ParametreController::class, 'activeparametresysteme'])->name('activeparametresysteme');
        Route::match(['get', 'post'], '/desactiveparametresysteme/{id}/{id1}', [App\Http\Controllers\ParametreController::class, 'desactiveparametresysteme'])->name('desactiveparametresysteme');
    });

    /*************************** Processus ***************************/
    Route::match(['get'], '/processus', [App\Http\Controllers\ProcessusController::class, 'index'])->name('processus');
    Route::match(['get', 'post'], '/processus/create', [App\Http\Controllers\ProcessusController::class, 'create'])->name('processusadd');
    Route::match(['get', 'post'], '/processus/edit/{id}', [App\Http\Controllers\ProcessusController::class, 'edit'])->name('processusedit');

    /*************************** demandes ***************************/
    Route::match(['get'], '/demandencours', [App\Http\Controllers\DemandeController::class, 'demandencours'])->name('demandencours');
    Route::match(['get'], '/demanderejetes', [App\Http\Controllers\DemandeController::class, 'demanderejetes'])->name('demanderejetes');



});
