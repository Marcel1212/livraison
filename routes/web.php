<?php

use App\Http\Controllers\AffectationProjetEtudeController;
use App\Http\Controllers\AgreementController;
use App\Http\Controllers\AgreementPfController;
use App\Http\Controllers\AgreementProjetEtudeController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\CahierprojetetudeController;
use App\Http\Controllers\ComiteGestionProjetEtudeController;
use App\Http\Controllers\ComitePermanenteProjetEtudeController;
use App\Http\Controllers\ComitePleniereProjetEtudeController;
use App\Http\Controllers\CtprojetetudevaliderController;
use App\Http\Controllers\DemandeAnnulationActionPlanController;
use App\Http\Controllers\MotDePasseOublieController;
use App\Http\Controllers\ProjetEtudeController;
use App\Http\Controllers\SelectionOperateurProjetEtudeController;
use App\Http\Controllers\TraitementProjetEtudeController;
use App\Http\Controllers\TraitementSelectionOperateurProjetEtudeController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/reload-captcha', [App\Http\Controllers\ConnexionController::class, 'reloadCaptcha'])->name('reloadCaptcha');

Route::view("/403", "errors.403")->name('403');
Route::view("/404", "errors.404")->name('404');
Route::view("/500", "errors.500")->name('500');
//Route::get('/403', function () { return redirect('/home/dashboard'); });

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
        //'roles' => App\Http\Controllers\RoleController::class,
        //'users' => App\Http\Controllers\UserController::class,
        //'permissions' => App\Http\Controllers\PermissionController::class,
        //'menus' => App\Http\Controllers\MenuController::class,
        //'sousmenus' => App\Http\Controllers\SousmenuController::class,
        //'agence' => App\Http\Controllers\AgenceController::class,
        //'direction' => App\Http\Controllers\DirectionController::class,
        //'departement' => App\Http\Controllers\DepartementController::class,
        //'service' => App\Http\Controllers\ServiceController::class,
        //'activites' => App\Http\Controllers\ActivitesController::class,
        //'centreimpot' => App\Http\Controllers\CentreImpotController::class,
        //'localite' => App\Http\Controllers\LocaliteController::class,
        'projetetude' => App\Http\Controllers\ProjetEtudeController::class,
        'projetformation' => App\Http\Controllers\ProjetFormationController::class,
        'enrolement' => App\Http\Controllers\EnrolementController::class,
        'comitetechniquepe' => App\Http\Controllers\CtprojetetudeController::class,
        //'statutoperations' => App\Http\Controllers\StatutOperationController::class,
        //'motifs' => App\Http\Controllers\MotifController::class,
        //'planformation' => App\Http\Controllers\PlanFormationController::class,
        //'typeentreprise' => App\Http\Controllers\TypeEntrepriseController::class,
        //'butformation' => App\Http\Controllers\ButFormationController::class,
        //'typeformation' => App\Http\Controllers\TypeFormationController::class,
        //'traitementplanformation' => App\Http\Controllers\TratementPlanFormationController::class,
        //'periodeexercice' => App\Http\Controllers\PeriodeExerciceController::class,
        //'ctplanformation' => App\Http\Controllers\CtplanformationController::class,
        'ctprojetformation' => App\Http\Controllers\CtprojetformationController::class, // Ajout ctprojet
        'ctprojetetude' => App\Http\Controllers\CtprojetetudeController::class,
        'ctplanformationvalider' => App\Http\Controllers\CtplanformationvaliderController::class,
        'ctprojetformationvalider' => App\Http\Controllers\CtprojetformationvaliderController::class,
        //'comitepleniere' => App\Http\Controllers\ComitePleniereController::class,
        //'ctplanformationpleniere' => App\Http\Controllers\ComitePleniereController::class,
        //'formejuridique' => App\Http\Controllers\FormeJuridiqueController::class,
        //'secteuractivite' => App\Http\Controllers\SecteurActiviteController::class,
        //'partentreprise' => App\Http\Controllers\PartEntrepriseController::class,
        //'typecomites' => App\Http\Controllers\TypeComiteController::class,
        //'agreement' => App\Http\Controllers\AgreementController::class,
        //'comitegestion' => App\Http\Controllers\ComiteGestionController::class,
        //'comitepermanente' => App\Http\Controllers\ComitePermanenteController::class,
    ]);

    /**********PROJET D'ETUDE DEBUT***********/

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

    //Cahier
    Route::get('cahierprojetetude/{id}/delete', [App\Http\Controllers\CahierprojetetudeController::class, 'delete'])->name('cahierprojetetude.delete');
    Route::get('cahierprojetetude/{id}/{id1}/edit', [App\Http\Controllers\CahierprojetetudeController::class, 'edit'])->name('cahierprojetetude.edit');
    Route::put('cahierprojetetude/{id}/{id1}/update', [App\Http\Controllers\CahierprojetetudeController::class, 'update'])->name('cahierprojetetude.update');
    Route::get('cahierprojetetude/index', [App\Http\Controllers\CahierprojetetudeController::class, 'index'])->name('cahierprojetetude.index');
    Route::get('cahierprojetetude', [App\Http\Controllers\CahierprojetetudeController::class, 'index'])->name('cahierprojetetude');
    Route::get('cahierprojetetude/create', [App\Http\Controllers\CahierprojetetudeController::class, 'create'])->name('cahierprojetetude.create');
    Route::post('cahierprojetetude/store', [App\Http\Controllers\CahierprojetetudeController::class, 'store'])->name('cahierprojetetude.store');
    Route::get('cahierprojetetude/{id}/show', [App\Http\Controllers\CahierprojetetudeController::class, 'show'])->name('cahierprojetetude.show');
    Route::get('cahierprojetetude/{id}/etat', [App\Http\Controllers\CahierprojetetudeController::class, 'etat'])->name('cahierprojetetude.etat');
    Route::get('cahierprojetetude/{id}/{id2}/agrement', [App\Http\Controllers\CahierprojetetudeController::class, 'agrement'])->name('cahierprojetetude.agrement');
    Route::get('cahierprojetetude/{id}/{id2}/{id3}/editer', [App\Http\Controllers\CahierprojetetudeController::class, 'editer'])->name('cahierprojetetude.editer');
    Route::post('cahierprojetetude/{id}/{id2}/{id3}/agrementupdate', [CahierprojetetudeController::class, 'agrementupdate'])->name('cahierprojetetude.agrementupdate');

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
    Route::post('comitepermanenteprojetetude/{id}/{id2}/{id3}/agrementupdate', [ComitePermanenteProjetEtudeController::class, 'agrementupdate'])->name('comitepermanenteprojetetude.agrementupdate');

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


    //Traitement sélection opérateur
    Route::get('traitementselectionoperateurprojetetude', [TraitementSelectionOperateurProjetEtudeController::class, 'index'])->name('traitementselectionoperateurprojetetude.index');
    Route::get('traitementselectionoperateurprojetetude/{id_projet_etude}/{id_combi_proc}/edit', [TraitementSelectionOperateurProjetEtudeController::class, 'edit'])->name('traitementselectionoperateurprojetetude.edit');
    Route::put('traitementselectionoperateurprojetetude/{id_projet_etude}/update', [TraitementSelectionOperateurProjetEtudeController::class, 'update'])->name('traitementselectionoperateurprojetetude.update');


    /**********PROJET D'ETUDE FIN***********/



    Route::group(['middleware' => ['can:role-index']], function () {
        Route::resources([
            'roles' => App\Http\Controllers\RoleController::class,
        ]);
    });

    Route::group(['middleware' => ['can:users-index']], function () {
        Route::resources([
            'users' => App\Http\Controllers\UserController::class,
        ]);
    });

    Route::group(['middleware' => ['can:permission-create']], function () {
        Route::resources([
            'permissions' => App\Http\Controllers\PermissionController::class,
        ]);
    });

    Route::group(['middleware' => ['can:module-create']], function () {
        Route::resources([
            'menus' => App\Http\Controllers\MenuController::class,
        ]);
    });

    Route::group(['middleware' => ['can:sous-module-create']], function () {
        Route::resources([
            'sousmenus' => App\Http\Controllers\SousmenuController::class,
        ]);
    });

    Route::group(['middleware' => ['can:agence-create']], function () {
        Route::resources([
            'agence' => App\Http\Controllers\AgenceController::class,
        ]);
    });

    Route::group(['middleware' => ['can:direction-create']], function () {
        Route::resources([
            'direction' => App\Http\Controllers\DirectionController::class,
        ]);
    });

    Route::group(['middleware' => ['can:departement-index']], function () {
        Route::resources([
            'departement' => App\Http\Controllers\DepartementController::class,
        ]);
    });

    Route::group(['middleware' => ['can:service-index']], function () {
        Route::resources([
            'service' => App\Http\Controllers\ServiceController::class,
        ]);
    });

    Route::group(['middleware' => ['can:activites-create']], function () {
        Route::resources([
            'activites' => App\Http\Controllers\ActivitesController::class,
        ]);
    });

    Route::group(['middleware' => ['can:centreimpot-create']], function () {
        Route::resources([
            'centreimpot' => App\Http\Controllers\CentreImpotController::class,
        ]);
    });

    Route::group(['middleware' => ['can:localite-create']], function () {
        Route::resources([
            'localite' => App\Http\Controllers\LocaliteController::class,
        ]);
    });

    Route::group(['middleware' => ['can:statutoperations-create']], function () {
        Route::resources([
            'statutoperations' => App\Http\Controllers\StatutOperationController::class,
        ]);
    });

    Route::group(['middleware' => ['can:motifs-create']], function () {
        Route::resources([
            'motifs' => App\Http\Controllers\MotifController::class,
        ]);
    });

    Route::group(['middleware' => ['can:typeentreprise-create']], function () {
        Route::resources([
            'typeentreprise' => App\Http\Controllers\TypeEntrepriseController::class,
        ]);
    });

    Route::group(['middleware' => ['can:butformation-create']], function () {
        Route::resources([
            'butformation' => App\Http\Controllers\ButFormationController::class,
        ]);
    });

    Route::group(['middleware' => ['can:typeformation-create']], function () {
        Route::resources([
            'typeformation' => App\Http\Controllers\TypeFormationController::class,
        ]);
    });

    Route::group(['middleware' => ['can:periodeexercice-create']], function () {
        Route::resources([
            'periodeexercice' => App\Http\Controllers\PeriodeExerciceController::class,
        ]);
    });

    Route::group(['middleware' => ['can:formejuridique-create']], function () {
        Route::resources([
            'formejuridique' => App\Http\Controllers\FormeJuridiqueController::class,
        ]);
    });

    Route::group(['middleware' => ['can:secteuractivite-create']], function () {
        Route::resources([
            'secteuractivite' => App\Http\Controllers\SecteurActiviteController::class,
        ]);
    });

    Route::group(['middleware' => ['can:partentreprise-create']], function () {
        Route::resources([
            'partentreprise' => App\Http\Controllers\PartEntrepriseController::class,
        ]);
    });

    Route::group(['middleware' => ['can:typecomites-create']], function () {
        Route::resources([
            'typecomites' => App\Http\Controllers\TypeComiteController::class,
        ]);
    });

    Route::group(['middleware' => ['can:traitementplanformation-index']], function () {
        Route::resources([
            'traitementplanformation' => App\Http\Controllers\TratementPlanFormationController::class,
        ]);
    });

    Route::group(['middleware' => ['can:ctplanformation-edit']], function () {
        Route::resources([
            'ctplanformation' => App\Http\Controllers\CtplanformationController::class,
        ]);
    });

//    Route::get('agreement/{id}/cancel', [App\Http\Controllers\AgreementController::class, 'cancel'])->name('agreement.cancel');
//    Route::post('agreement/{id}/cancel/store', [App\Http\Controllers\AgreementController::class, 'cancelStore'])->name('agreement.cancel.store');
    Route::put('agreement/{id_demande}/{id_plan}/cancel/update', [App\Http\Controllers\AgreementController::class, 'cancelUpdate'])->name('agreement.cancel.update');

    //Agrément
    //Route::group(['middleware' => ['can:ctplanformation-edit']], function () {
        Route::get('agreement', [AgreementController::class, 'index'])->name('agreement');
        Route::get('agreement/index', [AgreementController::class, 'index'])->name('agreement.index');
    //});
    Route::get('agreement/{id_plan_de_formation}/{id_etape}/edit', [AgreementController::class, 'edit'])->name('agreement.edit');
    Route::get('agreement/{id_plan_de_formation}/show', [AgreementController::class, 'show'])->name('agreement.show');

    // Agreement PF

    //Agrément
    Route::get('agreementpf', [AgreementPfController::class, 'index'])->name('agreementpf');
    Route::get('agreementpf/index', [AgreementPfController::class, 'index'])->name('agreementpf.index');
    Route::get('agreementpf/{id_plan_de_formation}/{id_etape}/edit', [AgreementPfController::class, 'edit'])->name('agreementpf.edit');
    Route::get('agreementpf/{id_plan_de_formation}/show', [AgreementPfController::class, 'show'])->name('agreementpf.show');

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

    //traitement

    Route::get('traitementdemandesubstitutionplan', [App\Http\Controllers\TraitementDemandeSubstitutionPlanController::class, 'index'])->name('traitementdemandesubstitutionplan.index');
    Route::get('traitementdemandesubstitutionplan/{id}/{id2}/edit', [App\Http\Controllers\TraitementDemandeSubstitutionPlanController::class, 'edit'])->name('traitementdemandesubstitutionplan.edit');
    Route::put('traitementdemandesubstitutionplan/{id}/update', [App\Http\Controllers\TraitementDemandeSubstitutionPlanController::class, 'update'])->name('traitementdemandesubstitutionplan.update');


    Route::get('traitementdemandeannulationplan', [App\Http\Controllers\TraitementDemandeAnnulationPlanController::class, 'index'])->name('traitementdemandeannulationplan.index');
    Route::get('traitementdemandeannulationplan/{id}/{id2}/edit', [App\Http\Controllers\TraitementDemandeAnnulationPlanController::class, 'edit'])->name('traitementdemandeannulationplan.edit');
    Route::put('traitementdemandeannulationplan/{id}/update', [App\Http\Controllers\TraitementDemandeAnnulationPlanController::class, 'update'])->name('traitementdemandeannulationplan.update');

   Route::put('comitetechniquepe/{id}/update', [App\Http\Controllers\CtprojetetudeController::class, 'update'])->name('comitetechniquepe.update');

    //'comitetechniquepe' => App\Http\Controllers\CtprojetetudeController::class,

    Route::group(['middleware' => ['can:ctplanformationpleniere-index']], function () {
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
});

    Route::get('ctprojetformation/{id}/delete', [App\Http\Controllers\CtprojetformationController::class, 'delete'])->name('ctprojetformation.delete');
    Route::get('ctprojetformation/{id}/{id2}/cahier', [App\Http\Controllers\CtprojetformationController::class, 'cahier'])->name('ctprojetformation.cahier');
    Route::get('ctprojetformation/{id}/{id2}/editer', [App\Http\Controllers\CtprojetformationController::class, 'editer'])->name('ctprojetformation.editer');
    Route::post('ctprojetformation/{id}/{id2}/cahierupdate', [App\Http\Controllers\CtprojetformationController::class, 'cahierupdate'])->name('ctprojetformation.cahierupdate');

    Route::get('comitepleniere/{id}/deletecomitepleniereprojetetude', [App\Http\Controllers\ComitePleniereController::class, 'delete'])->name('comitepleniere.delete');
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

    Route::group(['middleware' => ['can:planformation-index']], function () {
        Route::get('planformation/{id}/delete', [App\Http\Controllers\PlanFormationController::class, 'delete'])->name('planformation.delete');
        Route::get('planformation/{id}/{id1}/edit', [App\Http\Controllers\PlanFormationController::class, 'edit'])->name('planformation.edit');
        Route::put('planformation/{id}/{id1}/update', [App\Http\Controllers\PlanFormationController::class, 'update'])->name('planformation.update');
        Route::get('planformation/index', [App\Http\Controllers\PlanFormationController::class, 'index'])->name('planformation.index');
        Route::get('planformation', [App\Http\Controllers\PlanFormationController::class, 'index'])->name('planformation');
        Route::get('planformation/create', [App\Http\Controllers\PlanFormationController::class, 'create'])->name('planformation.create');
        Route::post('planformation/store', [App\Http\Controllers\PlanFormationController::class, 'store'])->name('planformation.store');
        Route::get('planformation/{id}/show', [App\Http\Controllers\PlanFormationController::class, 'show'])->name('planformation.show');
        Route::get('planformation/{id}/deleteapf', [App\Http\Controllers\PlanFormationController::class, 'deleteapf'])->name('planformation.deleteapf');
    });

    Route::group(['middleware' => ['can:cotisation-index']], function () {
        Route::get('cotisation', [App\Http\Controllers\CotisationController::class, 'index'])->name('cotisation');
        Route::get('cotisation/index', [App\Http\Controllers\CotisationController::class, 'index'])->name('cotisation.index');
        Route::get('cotisation/create', [App\Http\Controllers\CotisationController::class, 'create'])->name('cotisation.create');
        Route::post('cotisation/store', [App\Http\Controllers\CotisationController::class, 'store'])->name('cotisation.store');
        Route::get('cotisation/{id}/show', [App\Http\Controllers\CotisationController::class, 'show'])->name('cotisation.show');
    });

    /*Route::group(['middleware' => ['can:clederepartitionfinancement-index']], function () {
        Route::get('clederepartitionfinancement', [App\Http\Controllers\CotisationController::class, 'index'])->name('clederepartitionfinancement');
        Route::get('clederepartitionfinancement/index', [App\Http\Controllers\CotisationController::class, 'index'])->name('clederepartitionfinancement.index');
        Route::get('clederepartitionfinancement/create', [App\Http\Controllers\CotisationController::class, 'create'])->name('clederepartitionfinancement.create');
        Route::post('clederepartitionfinancement/store', [App\Http\Controllers\CotisationController::class, 'store'])->name('clederepartitionfinancement.store');
        Route::get('clederepartitionfinancement/{id}/show', [App\Http\Controllers\CotisationController::class, 'show'])->name('clederepartitionfinancement.show');
    });*/

    Route::group(['middleware' => ['can:clederepartitionfinancement-index']], function () {
        Route::resources([
            'clederepartitionfinancement' => App\Http\Controllers\CleDeRepartitionFinancementController::class,
        ]);
    });

    Route::group(['middleware' => ['can:comitegestion-create']], function () {
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
    });

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

    Route::group(['middleware' => ['can:comitepermanente-index']], function () {
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
    });
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

    Route::group(['middleware' => ['can:cahierplanformation-index']], function () {
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
    });

    Route::group(['middleware' => ['can:ctplanformationvalider-index']], function () {
        Route::resources([
            'ctplanformationvalider' => App\Http\Controllers\CtplanformationvaliderController::class,
        ]);
        Route::get('ctplanformationvalider/{id}/{id2}/editer', [App\Http\Controllers\CtplanformationvaliderController::class, 'editer'])->name('ctplanformationvalider.editer');
    });


    Route::get('agence/{id}/delete', [App\Http\Controllers\AgenceController::class, 'delete'])->name('agence.delete');
    Route::get('users/{id}/delete', [App\Http\Controllers\UserController::class, 'delete'])->name('users.delete');
    Route::get('/dashboard', [App\Http\Controllers\ConnexionController::class, 'dashboard'])->name('dashboard');

    Route::match(['get', 'post'], '/profil', [App\Http\Controllers\HomeController::class, 'profil'])->name('profil');

    Route::group(['middleware' => ['can:attribuer']], function () {
        Route::match(['get', 'post'], '/menuprofil', [App\Http\Controllers\GenerermenuController::class, 'parametragemenu'])->name('menuprofil');
        Route::match(['get', 'post'], '/menuprofillayout/{id}', [App\Http\Controllers\GenerermenuController::class, 'menuprofillayout'])->name('menuprofillayout');
    });


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
    Route::group(['middleware' => ['can:processus-create']], function () {
        Route::match(['get'], '/processus', [App\Http\Controllers\ProcessusController::class, 'index'])->name('processus');
        Route::match(['get', 'post'], '/processus/create', [App\Http\Controllers\ProcessusController::class, 'create'])->name('processusadd');
        Route::match(['get', 'post'], '/processus/edit/{id}', [App\Http\Controllers\ProcessusController::class, 'edit'])->name('processusedit');
    });
    /*************************** demandes ***************************/
    Route::match(['get'], '/demandencours', [App\Http\Controllers\DemandeController::class, 'demandencours'])->name('demandencours');
    Route::match(['get'], '/demanderejetes', [App\Http\Controllers\DemandeController::class, 'demanderejetes'])->name('demanderejetes');



});
