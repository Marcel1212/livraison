<?php

namespace App\Http\Controllers;
use App\Helpers\Crypt;
use App\Helpers\InfosEntreprise;
use App\Models\Entreprises;
use App\Models\Pays;
use App\Models\PiecesProjetEtude;
use App\Models\ProjetEtude;
use App\Models\SecteurActivite;
use App\Models\User;
use Illuminate\Http\Request;

class SelectionOperateurProjetEtudeController extends Controller{
    public function index(){
        $projet_etude_valides = ProjetEtude::where('flag_fiche_agrement',true)->get();
        return view('selectionoperateurprojetetude.index', compact('projet_etude_valides'));
    }

    public function edit($id_projet_etude,$idetape){
        $id_projet_etude = Crypt::UrldeCrypt($id_projet_etude);
        $idetape = Crypt::UrldeCrypt($idetape);

        if(isset($id_projet_etude)){
            $projet_etude_valide = ProjetEtude::where('flag_fiche_agrement',true)
                ->where('id_projet_etude',$id_projet_etude)->first();
            if(isset($projet_etude_valide)){
                $user = User::find($projet_etude_valide->id_user);
                $entreprise_mail = $user->email;
                $entreprise = InfosEntreprise::get_infos_entreprise($user->login_users);

                $operateur_selecteds = Entreprises::whereNotExists(function ($query) use ($id_projet_etude){
                    $query->select('*')
                        ->from('projet_etude_has_entreprises')
                        ->whereColumn('projet_etude_has_entreprises.id_entreprises','=','entreprises.id_entreprises')
                        ->where('projet_etude_has_entreprises.id_projet_etude',$id_projet_etude);
                })->where('flag_operateur',true)->where('flag_actif_entreprises',true)
                  ->where('id_secteur_activite_entreprise',$projet_etude_valide->id_secteur_activite)
                  ->get();

                $operateur_selected = "<option value=''> Selectionnez un opérateur </option>";
                foreach ($operateur_selecteds as $operateur) {
                    $operateur_selected .= "<option value='" .$operateur->id_entreprises. "'>" . mb_strtoupper($operateur->raison_social_entreprises) . " </option>";
                }


                $operateur_validers = Entreprises::whereExists(function ($query) use ($id_projet_etude){
                    $query->select('*')
                        ->from('projet_etude_has_entreprises')
                        ->whereColumn('projet_etude_has_entreprises.id_entreprises','=','entreprises.id_entreprises')
                        ->where('projet_etude_has_entreprises.id_projet_etude',$id_projet_etude);
                })->where('flag_operateur',true)->where('flag_actif_entreprises',true)
                    ->where('id_secteur_activite_entreprise',$projet_etude_valide->id_secteur_activite)
                    ->get();


                $operateur_valider = "<option value=''> Selectionnez un opérateur </option>";

                foreach ($operateur_validers as $op) {
                    $operateur_valider .= "<option value='" .$op->id_entreprises. "'>" . mb_strtoupper($op->raison_social_entreprises) . " </option>";
                }

                $pieces_projets = PiecesProjetEtude::where('id_projet_etude',$projet_etude_valide->id_projet_etude)->get();

                $pays = Pays::all();
                $pay = "<option value='".$entreprise->pay->id_pays."'> " . $entreprise->pay->indicatif . "</option>";
                foreach ($pays as $comp) {
                    $pay .= "<option value='" . $comp->id_pays  . "'>" . $comp->indicatif ." </option>";
                }

                $secteuractivite_projets = SecteurActivite::where('flag_actif_secteur_activite', '=', true)
                    ->orderBy('libelle_secteur_activite')
                    ->get();

                $secteuractivite_projet = "<option value='".$projet_etude_valide->secteurActivite->id_secteur_activite."'> " . $projet_etude_valide->secteurActivite->libelle_secteur_activite . "</option>";
                foreach ($secteuractivite_projets as $comp) {
                    $secteuractivite_projet .= "<option value='" . $comp->id_secteur_activite . "'>" . mb_strtoupper($comp->libelle_secteur_activite) . " </option>";
                }


                return view('selectionoperateurprojetetude.edit', compact('idetape','operateur_valider','operateur_selected','pay','secteuractivite_projet','pieces_projets','entreprise','entreprise_mail','projet_etude_valide'));
            }else{

            }
        }else{

        }
    }

    public function update(Request $request,$id_projet_etude){
        $id_projet_etude = Crypt::UrldeCrypt($id_projet_etude);
        if(isset($id_projet_etude)){
            $projet_etude_valide = ProjetEtude::where('flag_fiche_agrement',true)
                ->where('id_projet_etude',$id_projet_etude)->first();
            if(isset($projet_etude_valide)){
                if($request->action=="Enregistrer_selection"){
                    $projet_etude_valide->operateurs()->attach($request->operateur);
                    $projet_etude_valide->flag_soumis_selection_operateur = false;
                    $projet_etude_valide->flag_selection_operateur_valider_par_processus = false;
                    $projet_etude_valide->update();
                }

                if($request->action=="Enregistrer_soumettre_selection"){
                    $projet_etude_valide->id_processus_selection = 7;
                    $projet_etude_valide->flag_soumis_selection_operateur = true;
                    $projet_etude_valide->date_soumis_selection_operateur = now();
                    $projet_etude_valide->update();
                }
                return redirect('/selectionoperateurprojetetude/'.Crypt::UrlCrypt($id_projet_etude).'/'.Crypt::UrlCrypt(4).'/edit')->with('success','Succès: Sélection effectuée');
            }else{

            }
        }else{

        }
    }

    public function mark(Request $request,$id_projet_etude){
        $id_projet_etude = Crypt::UrldeCrypt($id_projet_etude);
        if(isset($id_projet_etude)){
            $projet_etude_valide = ProjetEtude::where('flag_fiche_agrement',true)
                ->where('id_projet_etude',$id_projet_etude)->first();
            if(isset($projet_etude_valide)){
                if($request->action=='Enregistrer_selection'){
                    $projet_etude_valide->id_operateur_selection = $request->operateur;
                    $projet_etude_valide->update();
                }

                if($request->action=='Valider_selection'){
                    $projet_etude_valide->flag_validation_selection_operateur = true;
                    $projet_etude_valide->date_validation_selection_operateur = now();
                    $projet_etude_valide->update();
                }
                return redirect('/selectionoperateurprojetetude/'.Crypt::UrlCrypt($id_projet_etude).'/'.Crypt::UrlCrypt(4).'/edit')->with('success','Succès: Sélection effectuée');
            }else{

            }
        }else{

        }
    }



    public function deleteoperateurpe(string $id_projet_etude,string $id_operateur)
    {
        $id_projet_etude = Crypt::UrldeCrypt($id_projet_etude);
        $id_operateur = Crypt::UrldeCrypt($id_operateur);
        if(isset($id_projet_etude)){
            $projet_etude_valide = ProjetEtude::where('flag_fiche_agrement',true)
                ->where('id_projet_etude',$id_projet_etude)->first();
            if(isset($projet_etude_valide)){
                $projet_etude_valide->operateurs()->detach($id_operateur);
                return redirect('/selectionoperateurprojetetude/'.Crypt::UrlCrypt($id_projet_etude).'/'.Crypt::UrlCrypt(4).'/edit')->with('success','Succès: Sélection effectuée');
            }else{

            }
        }else{

        }

    }
}
