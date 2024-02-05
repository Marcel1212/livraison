<?php

namespace App\Http\Controllers;

use App\Helpers\Crypt;
use App\Helpers\InfosEntreprise;
use App\Models\Entreprises;
use App\Models\PiecesProjetEtude;
use App\Models\ProjetEtude;
use App\Models\User;
use Illuminate\Http\Request;

class SelectionOperateurProjetEtudeController extends Controller{
    public function index(){
        $projet_etude_valides = ProjetEtude::where('flag_fiche_agrement',true)->get();
        return view('selectionoperateurprojetetude.index', compact('projet_etude_valides'));
    }

    public function edit($id_projet_etude){
        $id_projet_etude = Crypt::UrldeCrypt($id_projet_etude);

        if(isset($id_projet_etude)){
            $projet_etude_valide = ProjetEtude::where('flag_valide',true)
                ->where('id_projet_etude',$id_projet_etude)->first();
            if(isset($projet_etude_valide)){
                $operateurs = Entreprises::where('flag_operateur',true)->where('flag_actif_entreprises',true)
                    ->where('id_secteur_activite',$projet_etude_valide->id_secteur_activite)
                    ->get();

                $user = User::find($projet_etude_valide->id_user);
                $entreprise_mail = $user->email;
                $entreprise = InfosEntreprise::get_infos_entreprise($user->login_users);

                $piecesetude = PiecesProjetEtude::where('id_projet_etude',$id_projet_etude)
                    ->where('code_pieces','1')->first();
                $piecesetude1 = $piecesetude->libelle_pieces;

                $piecesetude = PiecesProjetEtude::where('id_projet_etude',$id_projet_etude)
                    ->where('code_pieces','2')->first();
                $piecesetude2 = $piecesetude->libelle_pieces;

                $piecesetude = PiecesProjetEtude::where('id_projet_etude',$id_projet_etude)
                    ->where('code_pieces','3')->first();
                $piecesetude3 = $piecesetude->libelle_pieces;

                $piecesetude = PiecesProjetEtude::where('id_projet_etude',$id_projet_etude)
                    ->where('code_pieces','4')->first();
                $piecesetude4 = $piecesetude->libelle_pieces;

                $piecesetude = PiecesProjetEtude::where('id_projet_etude',$id_projet_etude)
                    ->where('code_pieces','5')->first();
                $piecesetude5 = $piecesetude->libelle_pieces;

                $piecesetude = PiecesProjetEtude::where('id_projet_etude',$id_projet_etude)
                    ->where('code_pieces','6')->first();
                $piecesetude6 = $piecesetude->libelle_pieces;

                return view('selectionoperateurprojetetude.edit', compact('operateurs','piecesetude1','piecesetude2','piecesetude3','piecesetude4','piecesetude5','piecesetude6','entreprise','entreprise_mail','projet_etude_valide'));
            }else{

            }
        }else{

        }
    }

    public function update(Request $request,$id_projet_etude){
        $id_projet_etude = Crypt::UrldeCrypt($id_projet_etude);
        if(isset($id_projet_etude)){
            $projet_etude_valide = ProjetEtude::where('flag_valide',true)
                ->where('id_projet_etude',$id_projet_etude)->first();
            if(isset($projet_etude_valide)){
                $projet_etude_valide->operateurs()->sync($request->operateurs,true);

                if($request->action=="Enregistrer_selection"){
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
                return redirect('/selectionoperateurprojetetude/'.Crypt::UrlCrypt($id_projet_etude).'/edit')->with('success','Succès: Sélection effectuée');
            }else{

            }
        }else{

        }
    }

    public function mark(Request $request,$id_projet_etude){
        $id_projet_etude = Crypt::UrldeCrypt($id_projet_etude);
        if(isset($id_projet_etude)){
            $projet_etude_valide = ProjetEtude::where('flag_valide',true)
                ->where('id_projet_etude',$id_projet_etude)->first();
            if(isset($projet_etude_valide)){
                $projet_etude_valide->id_operateur_selection = $request->operateur;
                $projet_etude_valide->flag_validation_selection_operateur = true;
                $projet_etude_valide->date_validation_selection_operateur = now();
                $projet_etude_valide->update();
                return redirect('/selectionoperateurprojetetude/'.Crypt::UrlCrypt($id_projet_etude).'/edit')->with('success','Succès: Sélection effectuée');
            }else{

            }
        }else{

        }
    }
}
