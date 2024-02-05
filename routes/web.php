<?php

use App\Http\Controllers\AffectationProjetEtudeController;
use App\Http\Controllers\AgreementController;
use App\Http\Controllers\AgreementPfController;
use App\Http\Controllers\ComiteGestionProjetEtudeController;
use App\Http\Controllers\ComitePleniereProjetEtudeController;
use App\Http\Controllers\CtprojetetudevaliderController;
use App\Http\Controllers\DemandeAnnulationActionPlanController;
use App\Http\Controllers\MotDePasseOublieController;
use App\Http\Controllers\ProjetEtudeController;
use App\Http\Controllers\SelectionOperateurProjetEtudeController;
use App\Http\Controllers\TraitementProjetEtudeController;
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
        // Route::resources([
        //     'roles' => App\Http\Controllers\RoleController::class,
        //     'users' => App\Http\Controllers\UserController::class,
        //     'permissions' => App\Http\Controllers\PermissionController::class,
        //     'menus' => App\Http\Controllers\MenuController::class,
        //     'sousmenus' => App\Http\Controllers\SousmenuController::class,
        //     'agence' => App\Http\Controllers\AgenceController::class,
        //     'direction' => App\Http\Controllers\DirectionController::class,
        //     'departement' => App\Http\Controllers\DepartementController::class,
        //     'service' => App\Http\Controllers\ServiceController::class,
        //     'activites' => App\Http\Controllers\ActivitesController::class,
        //     'centreimpot' => App\Http\Controllers\CentreImpotController::class,
        //     'localite' => App\Http\Controllers\LocaliteController::class,
        //     'projetetude' => App\Http\Controllers\ProjetEtudeController::class,
        //     'projetformation' => App\Http\Controllers\ProjetFormationController::class,
        //     'enrolement' => App\Http\Controllers\EnrolementController::class,
        //     'statutoperations' => App\Http\Controllers\StatutOperationController::class,
        //     'motifs' => App\Http\Controllers\MotifController::class,
        //     //'planformation' => App\Http\Controllers\PlanFormationController::class,
        //     'comitegestionpe' => App\Http\Controllers\ComiteGestionPeController::class,
        //     'typeentreprise' => App\Http\Controllers\TypeEntrepriseController::class,
        //     'butformation' => App\Http\Controllers\ButFormationController::class,
        //     'typeformation' => App\Http\Controllers\TypeFormationController::class,
        //     'traitementplanformation' => App\Http\Controllers\TratementPlanFormationController::class,
        //     'periodeexercice' => App\Http\Controllers\PeriodeExerciceController::class,
        //     'ctplanformation' => App\Http\Controllers\CtplanformationController::class,
        //     'comitetechniquepe' => App\Http\Controllers\CtprojetetudeController::class,
        //     'ctplanformationvalider' => App\Http\Controllers\CtplanformationvaliderController::class,
        //     'comitepleniere' => App\Http\Controllers\ComitePleniereController::class,
        //     'formejuridique' => App\Http\Controllers\FormeJuridiqueController::class,
        //     'secteuractivite' => App\Http\Controllers\SecteurActiviteController::class,
        //     'partentreprise' => App\Http\Controllers\PartEntrepriseController::class,
        //     'typecomites' => App\Http\Controllers\TypeComiteController::class,

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
        'projetformation' => App\Http\Controllers\ProjetFormationController::class,
        'enrolement' => App\Http\Controllers\EnrolementController::class,
        'comitetechniquepe' => App\Http\Controllers\CtprojetetudeController::class,
        'statutoperations' => App\Http\Controllers\StatutOperationController::class,
        'motifs' => App\Http\Controllers\MotifController::class,
        //'planformation' => App\Http\Controllers\PlanFormationController::class,
        'typeentreprise' => App\Http\Controllers\TypeEntrepriseController::class,
        'butformation' => App\Http\Controllers\ButFormationController::class,
        'typeformation' => App\Http\Controllers\TypeFormationController::class,
        'ctprojetformation' => App\Http\Controllers\CtprojetformationController::class, // Ajout ctprojet
        'traitementplanformation' => App\Http\Controllers\TratementPlanFormationController::class,
        'periodeexercice' => App\Http\Controllers\PeriodeExerciceController::class,
        'ctplanformation' => App\Http\Controllers\CtplanformationController::class,
        'ctprojetetude' => App\Http\Controllers\CtprojetetudeController::class,
        'ctplanformationvalider' => App\Http\Controllers\CtplanformationvaliderController::class,
        //'comitepleniere' => App\Http\Controllers\ComitePleniereController::class,
        //'ctplanformationpleniere' => App\Http\Controllers\ComitePleniereController::class,
        'formejuridique' => App\Http\Controllers\FormeJuridiqueController::class,
        'secteuractivite' => App\Http\Controllers\SecteurActiviteController::class,
        'partentreprise' => App\Http\Controllers\PartEntrepriseController::class,
        'typecomites' => App\Http\Controllers\TypeComiteController::class,
//            'agreement' => App\Http\Controllers\AgreementController::class,
        //'comitegestion' => App\Http\Controllers\ComiteGestionController::class,
        //'comitepermanente' => App\Http\Controllers\ComitePermanenteController::class,
    ]);

    /**********PROJET D'ETUDE***********/
    //Demande projet d'étude
    Route::get('projetetude', [ProjetEtudeController::class, 'index'])->name('projetetude');
    Route::get('projetetude/index', [ProjetEtudeController::class, 'index'])->name('projetetude.index');
    Route::get('projetetude/create', [ProjetEtudeController::class, 'create'])->name('projetetude.create');
    Route::post('projetetude/store', [ProjetEtudeController::class, 'store'])->name('projetetude.store');
    Route::get('projetetude/{id}/{id_etape}/edit', [ProjetEtudeController::class, 'edit'])->name('projetetude.edit');
    Route::put('projetetude/{id}/{id_etape}/update', [ProjetEtudeController::class, 'update'])->name('projetetude.update');
    Route::get('projetetude/{id}/{id_piece_projet}/deletefpe', [ProjetEtudeController::class, 'deletefpe'])->name('projetetude.deletefpe');

    //Affectation projet d'étude
    Route::get('affectationprojetetude', [AffectationProjetEtudeController::class, 'index'])->name('affectationprojetetude');
    Route::get('affectationprojetetude/index', [AffectationProjetEtudeController::class, 'index'])->name('affectationprojetetude.index');
    Route::get('affectationprojetetude/{id}/{id_etape}/edit', [AffectationProjetEtudeController::class, 'edit'])->name('affectationprojetetude.edit');
    Route::put('affectationprojetetude/{id}/update', [AffectationProjetEtudeController::class, 'update'])->name('affectationprojetetude.update');

    //Traitement de projet d'étude
    Route::get('traitementprojetetude', [TraitementProjetEtudeController::class, 'index'])->name('traitementprojetetude');
    Route::get('traitementprojetetude/index', [TraitementProjetEtudeController::class, 'index'])->name('traitementprojetetude.index');
    Route::get('traitementprojetetude/{id}/{id_etape}/edit', [TraitementProjetEtudeController::class, 'edit'])->name('traitementprojetetude.edit');
    Route::put('traitementprojetetude/{id}/update', [TraitementProjetEtudeController::class, 'update'])->name('traitementprojetetude.update');

    //Comité plénière projet d'étude
    Route::get('comitepleniereprojetetude', [ComitePleniereProjetEtudeController::class, 'index'])->name('comitepleniereprojetetude');
    Route::get('comitepleniereprojetetude/index', [ComitePleniereProjetEtudeController::class, 'index'])->name('comitepleniereprojetetude.index');
    Route::get('comitepleniereprojetetude/create', [ComitePleniereProjetEtudeController::class, 'create'])->name('comitepleniereprojetetude.create');
    Route::post('comitepleniereprojetetude/store', [ComitePleniereProjetEtudeController::class, 'store'])->name('comitepleniereprojetetude.store');
    Route::get('comitepleniereprojetetude/{id}/edit', [ComitePleniereProjetEtudeController::class, 'edit'])->name('comitepleniereprojetetude.edit');
    Route::put('comitepleniereprojetetude/{id}/update', [ComitePleniereProjetEtudeController::class, 'update'])->name('comitepleniereprojetetude.update');
    Route::get('comitepleniereprojetetude/{id}/delete', [ComitePleniereProjetEtudeController::class, 'delete'])->name('comitepleniereprojetetude.delete');
    Route::get('comitepleniereprojetetude/{id}/{id2}/editer', [ComitePleniereProjetEtudeController::class, 'editer'])->name('comitepleniereprojetetude.editer');

    //workflow de validation
    Route::get('ctprojetetudevalider', [CtprojetetudevaliderController::class, 'index'])->name('ctprojetetudevalider.index');
    Route::get('ctprojetetudevalider/{id_projet_etude}/{id_combi_proc}/edit', [CtprojetetudevaliderController::class, 'edit'])->name('ctprojetetudevalider.edit');
    Route::put('ctprojetetudevalider/{id_projet_etude}/update', [CtprojetetudevaliderController::class, 'update'])->name('ctprojetetudevalider.update');

    //comité de gestion

    Route::get('comitegestionprojetetude', [ComiteGestionProjetEtudeController::class, 'index'])->name('comitegestionprojetetude');
    Route::get('comitegestionprojetetude/index', [ComiteGestionProjetEtudeController::class, 'index'])->name('comitegestionprojetetude.index');
    Route::get('comitegestionprojetetude/create', [ComiteGestionProjetEtudeController::class, 'create'])->name('comitegestionprojetetude.create');
    Route::post('comitegestionprojetetude/store', [ComiteGestionProjetEtudeController::class, 'store'])->name('comitegestionprojetetude.store');
    Route::get('comitegestionprojetetude/{id}/edit', [ComiteGestionProjetEtudeController::class, 'edit'])->name('comitegestionprojetetude.edit');
    Route::put('comitegestionprojetetude/{id}/update', [ComiteGestionProjetEtudeController::class, 'update'])->name('comitegestionprojetetude.update');
    Route::get('comitegestionprojetetude/{id}/delete', [ComiteGestionProjetEtudeController::class, 'delete'])->name('comitegestionprojetetude.delete');
    Route::get('comitegestionprojetetude/{id}/{id2}/editer', [ComiteGestionProjetEtudeController::class, 'editer'])->name('comitegestionprojetetude.editer');



//    Route::get('agreement/{id}/cancel', [App\Http\Controllers\AgreementController::class, 'cancel'])->name('agreement.cancel');
//    Route::post('agreement/{id}/cancel/store', [App\Http\Controllers\AgreementController::class, 'cancelStore'])->name('agreement.cancel.store');
    Route::put('agreement/{id_demande}/{id_plan}/cancel/update', [App\Http\Controllers\AgreementController::class, 'cancelUpdate'])->name('agreement.cancel.update');

    //Agrément
    Route::get('agreement', [AgreementController::class, 'index'])->name('agreement');
    Route::get('agreement/index', [AgreementController::class, 'index'])->name('agreement.index');
    Route::get('agreement/{id_plan_de_formation}/{id_etape}/edit', [AgreementController::class, 'edit'])->name('agreement.edit');
    Route::get('agreement/{id_plan_de_formation}/show', [AgreementController::class, 'show'])->name('agreement.show');

    Route::get('agreement/{id_plan_de_formation}/{id_action}/{id_etape}/editaction', [AgreementController::class, 'editaction'])->name('agreement.editaction');
    Route::post('agreement/{id_plan_de_formation}/{id_action}/{id_etape}/editactioncancel', [AgreementController::class, 'editactionCancel'])->name('agreement.editactioncancel');


//    /{id_plan_de_formation}/{id_etape}/cancel

    //Demande Annulation Agrément
    Route::post('agreement/{id_plan_de_formation}/{id_etape}/cancel', [AgreementController::class, 'cancel'])->name('agreement.cancel');

//    Route::put('agreement/{id_demande}/{id_plan}/cancel/update', [App\Http\Controllers\AgreementController::class, 'cancelUpdate'])->name('agreement.cancel.update');

    Route::get('agreement/{id_plan}/{id_action}/substitution', [App\Http\Controllers\AgreementController::class, 'substitution'])->name('agreement.substitution');
    Route::post('agreement/{id_plan}/{id_action}/substitution', [App\Http\Controllers\AgreementController::class, 'substitutionsStore'])->name('agreement.substitution');
    Route::put('agreement/{id_plan}/{id_action}/substitution', [App\Http\Controllers\AgreementController::class, 'substitutionsUpdate'])->name('agreement.substitution');
    //    Route::get('comitepermanente/{id}/{id1}/edit', [App\Http\Controllers\ComitePermanenteController::class, 'edit'])->name('comitepermanente.edit');


    // Agrement projet formation
    Route::put('agreementpf/{id_demande}/{id_plan}/cancel/update', [App\Http\Controllers\AgreementPfController::class, 'cancelUpdate'])->name('agreementpf.cancel.update');
    Route::get('agreementpf', [App\Http\Controllers\AgreementPfController::class, 'index'])->name('agreementpf');
    Route::get('agreementpf/index', [App\Http\Controllers\AgreementPfController::class, 'index'])->name('agreementpf.index');
    Route::get('agreementpf/{id_plan_de_formation}/{id_etape}/edit', [App\Http\Controllers\AgreementPfController::class, 'edit'])->name('agreementpf.edit');
    Route::get('agreementpf/{id_plan_de_formation}/show', [App\Http\Controllers\AgreementPfController::class, 'show'])->name('agreementpf.show');

    Route::get('agreementpf/{id_plan_de_formation}/{id_action}/{id_etape}/editaction', [App\Http\Controllers\AgreementPfController::class, 'editaction'])->name('agreementpf.editaction');
    Route::post('agreementpf/{id_plan_de_formation}/{id_action}/{id_etape}/editactioncancel', [App\Http\Controllers\AgreementPfController::class, 'editactionCancel'])->name('agreementpf.editactioncancel');






    //traitement

    Route::get('traitementdemandesubstitutionplan', [App\Http\Controllers\TraitementDemandeSubstitutionPlanController::class, 'index'])->name('traitementdemandesubstitutionplan.index');
    Route::get('traitementdemandesubstitutionplan/{id}/{id2}/edit', [App\Http\Controllers\TraitementDemandeSubstitutionPlanController::class, 'edit'])->name('traitementdemandesubstitutionplan.edit');
    Route::put('traitementdemandesubstitutionplan/{id}/update', [App\Http\Controllers\TraitementDemandeSubstitutionPlanController::class, 'update'])->name('traitementdemandesubstitutionplan.update');


    Route::get('traitementdemandeannulationplan', [App\Http\Controllers\TraitementDemandeAnnulationPlanController::class, 'index'])->name('traitementdemandeannulationplan.index');
    Route::get('traitementdemandeannulationplan/{id}/{id2}/edit', [App\Http\Controllers\TraitementDemandeAnnulationPlanController::class, 'edit'])->name('traitementdemandeannulationplan.edit');
    Route::put('traitementdemandeannulationplan/{id}/update', [App\Http\Controllers\TraitementDemandeAnnulationPlanController::class, 'update'])->name('traitementdemandeannulationplan.update');

   Route::put('comitetechniquepe/{id}/update', [App\Http\Controllers\CtprojetetudeController::class, 'update'])->name('comitetechniquepe.update');

    //'comitetechniquepe' => App\Http\Controllers\CtprojetetudeController::class,
    //Sélection opérateur pour projet d'étude
    Route::get('selectionoperateurprojetetude', [SelectionOperateurProjetEtudeController::class, 'index'])->name('selectionoperateurprojetetude.index');
    Route::get('selectionoperateurprojetetude/{id_projet_etude}/edit', [SelectionOperateurProjetEtudeController::class, 'edit'])->name('selectionoperateurprojetetude.edit');
    Route::post('selectionoperateurprojetetude/{id_projet_etude}/update', [SelectionOperateurProjetEtudeController::class, 'update'])->name('selectionoperateurprojetetude.update');
    Route::put('selectionoperateurprojetetude/{id_projet_etude}/mark', [SelectionOperateurProjetEtudeController::class, 'mark'])->name('selectionoperateurprojetetude.mark');

    //
    Route::get('traitementselectionoperateurprojetetude', [TraitementSelectionOperateurProjetEtudeController::class, 'index'])->name('traitementselectionoperateurprojetetude.index');
    Route::get('traitementselectionoperateurprojetetude/{id_projet_etude}/{id_combi_proc}/edit', [TraitementSelectionOperateurProjetEtudeController::class, 'edit'])->name('traitementselectionoperateurprojetetude.edit');
    Route::put('traitementselectionoperateurprojetetude/{id_projet_etude}/update', [TraitementSelectionOperateurProjetEtudeController::class, 'update'])->name('traitementselectionoperateurprojetetude.update');


    Route::get('ctplanformationpleniere/{id}/{id1}/edit', [App\Http\Controllers\ComitePleniereController::class, 'edit'])->name('ctplanformationpleniere.edit');
    Route::put('ctplanformationpleniere/{id}/{id1}/update', [App\Http\Controllers\ComitePleniereController::class, 'update'])->name('ctplanformationpleniere.update');
    Route::get('ctplanformationpleniere/index', [App\Http\Controllers\ComitePleniereController::class, 'index'])->name('ctplanformationpleniere.index');
    Route::get('ctplanformationpleniere', [App\Http\Controllers\ComitePleniereController::class, 'index'])->name('ctplanformationpleniere');
    Route::get('ctplanformationpleniere/create', [App\Http\Controllers\ComitePleniereController::class, 'create'])->name('ctplanformationpleniere.create');
    Route::post('ctplanformationpleniere/store', [App\Http\Controllers\ComitePleniereController::class, 'store'])->name('ctplanformationpleniere.store');
    Route::get('ctplanformationpleniere/{id}/show', [App\Http\Controllers\ComitePleniereController::class, 'show'])->name('ctplanformationpleniere.show');
    Route::get('ctplanformationpleniere/{id}/delete', [App\Http\Controllers\ComitePleniereController::class, 'delete'])->name('ctplanformationpleniere.delete');
    Route::get('ctplanformationpleniere/{id}/{id2}/{id3}/cahier', [App\Http\Controllers\ComitePleniereController::class, 'cahier'])->name('ctplanformationpleniere.cahier');
    Route::get('ctplanformationpleniere/{id}/{id2}/{id3}/editer', [App\Http\Controllers\ComitePleniereController::class, 'editer'])->name('ctplanformationpleniere.editer');
    Route::post('ctplanformationpleniere/{id}/{id2}/{id3}/cahierupdate', [App\Http\Controllers\ComitePleniereController::class, 'cahierupdate'])->name('ctplanformationpleniere.cahierupdate');


    Route::get('ctprojetformation/{id}/delete', [App\Http\Controllers\CtprojetformationController::class, 'delete'])->name('ctprojetformation.delete');
    Route::get('ctprojetformation/{id}/{id2}/cahier', [App\Http\Controllers\CtprojetformationController::class, 'cahier'])->name('ctprojetformation.cahier');
    Route::get('ctprojetformation/{id}/{id2}/editer', [App\Http\Controllers\CtprojetformationController::class, 'editer'])->name('ctprojetformation.editer');
    Route::post('ctprojetformation/{id}/{id2}/cahierupdate', [App\Http\Controllers\CtprojetformationController::class, 'cahierupdate'])->name('ctprojetformation.cahierupdate');

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


    // Comite gestion projet etude
    Route::get('comitegestionpe/{id}/delete', [App\Http\Controllers\ComiteGestionPeController::class, 'delete'])->name('comitegestionpe.delete');
    Route::get('comitegestionpe/{id}/{id1}/edit', [App\Http\Controllers\ComiteGestionPeController::class, 'edit'])->name('comitegestionpe.edit');
    Route::put('comitegestionpe/{id}/{id1}/update', [App\Http\Controllers\ComiteGestionPeController::class, 'update'])->name('comitegestionpe.update');
    Route::get('comitegestionpe/index', [App\Http\Controllers\ComiteGestionPeController::class, 'index'])->name('comitegestionpe.index');
    Route::get('comitegestionpe', [App\Http\Controllers\ComiteGestionPeController::class, 'index'])->name('comitegestionpe');
    Route::get('comitegestionpe/create', [App\Http\Controllers\ComiteGestionPeController::class, 'create'])->name('comitegestionpe.create');
    Route::post('comitegestionpe/store', [App\Http\Controllers\ComiteGestionPeController::class, 'store'])->name('comitegestionpe.store');
    Route::get('comitegestionpe/{id}/show', [App\Http\Controllers\ComiteGestionPeController::class, 'show'])->name('comitegestionpe.show');
    Route::get('comitegestionpe/{id}/{id2}/agrement', [App\Http\Controllers\ComiteGestionPeController::class, 'agrement'])->name('comitegestionpe.agrement');
    Route::get('comitegestionpe/{id}/{id2}/{id3}/editer', [App\Http\Controllers\ComiteGestionPeController::class, 'editer'])->name('comitegestionpe.editer');
    Route::post('comitegestionpe/{id}/{id2}/{id3}/agrementupdate', [App\Http\Controllers\ComiteGestionPeController::class, 'agrementupdate'])->name('comitegestionpe.agrementupdate');


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

    // Comite permanente projet formation

    Route::get('comitepermanentepf/{id}/delete', [App\Http\Controllers\ComitePermanentePfController::class, 'delete'])->name('comitepermanentepf.delete');
    Route::get('comitepermanentepf/{id}/{id1}/edit', [App\Http\Controllers\ComitePermanentePfController::class, 'edit'])->name('comitepermanentepf.edit');
    Route::put('comitepermanentepf/{id}/{id1}/update', [App\Http\Controllers\ComitePermanentePfController::class, 'update'])->name('comitepermanentepf.update');
    Route::get('comitepermanentepf/index', [App\Http\Controllers\ComitePermanentePfController::class, 'index'])->name('comitepermanentepf.index');
    Route::get('comitepermanentepf', [App\Http\Controllers\ComitePermanentePfController::class, 'index'])->name('comitepermanentepf');
    Route::get('comitepermanentepf/create', [App\Http\Controllers\ComitePermanentePfController::class, 'create'])->name('comitepermanentepf.create');
    Route::post('comitepermanentepf/store', [App\Http\Controllers\ComitePermanentePfController::class, 'store'])->name('comitepermanentepf.store');
    Route::get('comitepermanentepf/{id}/show', [App\Http\Controllers\ComitePermanentePfController::class, 'show'])->name('comitepermanentepf.show');
    Route::get('comitepermanentepf/{id}/{id2}/agrement', [App\Http\Controllers\ComitePermanentePfController::class, 'agrement'])->name('comitepermanentepf.agrement');
    Route::get('comitepermanentepf/{id}/{id2}/{id3}/editer', [App\Http\Controllers\ComitePermanentePfController::class, 'editer'])->name('comitepermanentepf.editer');
    Route::post('comitepermanentepf/{id}/{id2}/agrementupdate', [App\Http\Controllers\ComitePermanentePfController::class, 'agrementupdate'])->name('comitepermanentepf.agrementupdate');


    // Comite de gestion projet de formation
    Route::get('comitegestionpf/{id}/delete', [App\Http\Controllers\ComiteGestionPfController::class, 'delete'])->name('comitegestionpf.delete');
    Route::get('comitegestionpf/{id}/{id1}/edit', [App\Http\Controllers\ComiteGestionPfController::class, 'edit'])->name('comitegestionpf.edit');
    Route::put('comitegestionpf/{id}/{id1}/update', [App\Http\Controllers\ComiteGestionPfController::class, 'update'])->name('comitegestionpf.update');
    Route::get('comitegestionpf/index', [App\Http\Controllers\ComiteGestionPfController::class, 'index'])->name('comitegestionpf.index');
    Route::get('comitegestionpf', [App\Http\Controllers\ComiteGestionPfController::class, 'index'])->name('comitegestionpf');
    Route::get('comitegestionpf/create', [App\Http\Controllers\ComiteGestionPfController::class, 'create'])->name('comitegestionpf.create');
    Route::post('comitegestionpf/store', [App\Http\Controllers\ComiteGestionPfController::class, 'store'])->name('comitegestionpf.store');
    Route::get('comitegestionpf/{id}/show', [App\Http\Controllers\ComiteGestionPfController::class, 'show'])->name('comitegestionpf.show');
    Route::get('comitegestionpf/{id}/{id2}/agrement', [App\Http\Controllers\ComiteGestionPfController::class, 'agrement'])->name('comitegestionpf.agrement');
    Route::get('comitegestionpf/{id}/{id2}/{id3}/editer', [App\Http\Controllers\ComiteGestionPfController::class, 'editer'])->name('comitegestionpf.editer');
    Route::post('comitegestionpf/{id}/{id2}/agrementupdate', [App\Http\Controllers\ComiteGestionPfController::class, 'agrementupdate'])->name('comitegestionpf.agrementupdate');



   // Route::post('comitepermanentepf/{id}/{id2}/{id3}/agrementupdate', [App\Http\Controllers\ComitePermanentePfController::class, 'agrementupdate'])->name('comitepermanentepf.agrementupdate');
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

    Route::match(['get', 'post'], '/profil', [App\Http\Controllers\HomeController::class, 'profil'])->name('profil');

    //Route::group(['middleware' => ['can:attribuer']], function () {
        Route::match(['get', 'post'], '/menuprofil', [App\Http\Controllers\GenerermenuController::class, 'parametragemenu'])->name('menuprofil');
        Route::match(['get', 'post'], '/menuprofillayout/{id}', [App\Http\Controllers\GenerermenuController::class, 'menuprofillayout'])->name('menuprofillayout');
    //});


    Route::match(['get', 'post'], '/modifiermotdepasse', [App\Http\Controllers\HomeController::class, 'updatepassword'])->name('modifier.mot.passe');
    Route::match(['get', 'post'], '/deleteactiviteentreprise/{id}', [App\Http\Controllers\HomeController::class, 'deleteactiviteentreprise'])->name('deleteactiviteentreprise');



    Route::group(['middleware' => ['can:parametresysteme-create']], function () {
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
