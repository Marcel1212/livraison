<?php

namespace App\Http\Controllers;

use App\Helpers\Audit;
use App\Helpers\Crypt;
use App\Models\CahierCommissionEvaluationOffre;
use App\Models\CommissionEvaluationOffre;
use App\Models\CommissionParticipantEvaluationOffre;
use App\Models\Entreprises;
use App\Models\FormeJuridique;
use App\Models\Motif;
use App\Models\NotationCommissionEvaluationOffreTech;
use App\Models\OffreTechCommissionEvaluationOffre;
use App\Models\Pays;
use App\Models\PiecesProjetEtude;
use App\Models\ProjetEtude;
use App\Models\SecteurActivite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
@ini_set('max_execution_time',0);
class TraitementCommissionEvaluationOffreController extends Controller
{
    public function index()
    {
        $commissionevals = CommissionEvaluationOffre::Join('commission_evaluation_offre_participant','commission_evaluation_offre.id_commission_evaluation_offre','commission_evaluation_offre_participant.id_commission_evaluation_offre')
            ->where('id_user_commission_evaluation_offre_participant',Auth::user()->id)
            ->where('commission_evaluation_offre_participant.flag_statut_valider_commission_evaluation_offre_participant',false)
            ->where('flag_statut_commission_evaluation_offre',false)
            ->get();

        Audit::logSave([
            'action'=>'INDEX',
            'code_piece'=>'',
            'menu'=>'EVALUATION OFFRE',
            'etat'=>'Succès',
            'objet'=>'TRAITEMENT EVALUATION COMMISSION'
        ]);

        return view('evaluationoffre.traitementcommission.index', compact('commissionevals'));
    }

    public function edit($id,$id1)
    {
        $id =  Crypt::UrldeCrypt($id);
        $idetape =  Crypt::UrldeCrypt($id1);
        $formjuridiques = FormeJuridique::where('flag_actif_forme_juridique',true)->get();

        if(isset($id)){
            $cahier = CahierCommissionEvaluationOffre::where('id_commission_evaluation_offre',$id)->first();
            $commissioneparticipant = CommissionParticipantEvaluationOffre::where('id_commission_evaluation_offre',$id)->first();
            $offretechcommissionevals = OffreTechCommissionEvaluationOffre::where('id_commission_evaluation_offre',$id)
                ->Join('critere_evaluation_offre_tech','offre_tech_commission_evaluation_offre.id_critere_evaluation_offre_tech','critere_evaluation_offre_tech.id_critere_evaluation_offre_tech')
                ->select('critere_evaluation_offre_tech.*','offre_tech_commission_evaluation_offre.*')
                ->get()
                ->groupby('libelle_critere_evaluation_offre_tech');


            $offretechcommissionevalsouscriteres = OffreTechCommissionEvaluationOffre::where('id_commission_evaluation_offre',$id)->count();

            $note_commissions = NotationCommissionEvaluationOffreTech::where('id_commission_evaluation_offre',@$cahier->id_commission_evaluation_offre)
                ->where('id_user_notation_commission_evaluation_offre',Auth::user()->id)
                ->count();

            if(isset($cahier)){
                $pieces_projets= PiecesProjetEtude::where('id_projet_etude',$cahier->id_projet_etude)->get();
                $avant_projet_tdr = PiecesProjetEtude::where('id_projet_etude',$cahier->id_projet_etude)
                    ->where('code_pieces','avant_projet_tdr')->first();
                $courier_demande_fin = PiecesProjetEtude::where('id_projet_etude',$cahier->id_projet_etude)
                    ->where('code_pieces','courier_demande_fin')->first();
                $dossier_intention = PiecesProjetEtude::where('id_projet_etude',$cahier->id_projet_etude)
                    ->where('code_pieces','dossier_intention')->first();
                $lettre_engagement = PiecesProjetEtude::where('id_projet_etude',$cahier->id_projet_etude)
                    ->where('code_pieces','lettre_engagement')->first();
                $offre_technique = PiecesProjetEtude::where('id_projet_etude',$cahier->id_projet_etude)
                    ->where('code_pieces','offre_technique')->first();
                $offre_financiere = PiecesProjetEtude::where('id_projet_etude',$cahier->id_projet_etude)
                    ->where('code_pieces','offre_financiere')->first();

                $infoentreprise = Entreprises::find($cahier->projet_etude->id_entreprises)->first();

                $pays = Pays::all();
                $pay = "<option value='".$infoentreprise->pay->id_pays."'> " . $infoentreprise->pay->indicatif . "</option>";
                foreach ($pays as $comp) {
                    $pay .= "<option value='" . $comp->id_pays  . "'>" . $comp->indicatif ." </option>";
                }

                $formjuridique = "<option value='".$infoentreprise->formeJuridique->id_forme_juridique."'> " . $infoentreprise->formeJuridique->libelle_forme_juridique . "</option>";

                foreach ($formjuridiques as $comp) {
                    $formjuridique .= "<option value='" . $comp->id_forme_juridique  . "'>" . $comp->libelle_forme_juridique ." </option>";
                }

                /******************** secteuractivites *********************************/
                $secteuractivites = SecteurActivite::where('flag_actif_secteur_activite', '=', true)
                    ->orderBy('libelle_secteur_activite')
                    ->get();
                $secteuractivite = "<option value=''> Selectionnez un secteur activité </option>";
                foreach ($secteuractivites as $comp) {
                    $secteuractivite .= "<option value='" . $comp->id_secteur_activite . "'>" . mb_strtoupper($comp->libelle_secteur_activite) . " </option>";
                }

                $secteuractivite_projets = SecteurActivite::where('flag_actif_secteur_activite', '=', true)
                    ->orderBy('libelle_secteur_activite')
                    ->get();

                $secteuractivite_projet = "<option value='".$cahier->projet_etude->secteurActivite->id_secteur_activite."'> " . $cahier->projet_etude->secteurActivite->libelle_secteur_activite . "</option>";
                foreach ($secteuractivite_projets as $comp) {
                    $secteuractivite_projet .= "<option value='" . $comp->id_secteur_activite . "'>" . mb_strtoupper($comp->libelle_secteur_activite) . " </option>";
                }

                return view('evaluationoffre.traitementcommission.edit',
                    compact('idetape',
                        'pay',
                        'pieces_projets',
                        'avant_projet_tdr',
                        'courier_demande_fin',
                        'dossier_intention',
                        'lettre_engagement',
                        'cahier',
                        'offretechcommissionevals',
                        'commissioneparticipant',
                        'offre_technique',
                        'note_commissions',
                        'offretechcommissionevalsouscriteres',
                        'formjuridique',
                        'secteuractivite_projet',
                        'id',
                        'offre_financiere',
                        'secteuractivite'));
            }
        }

    }

    public function notation($id,Request $request){
        $id =  Crypt::UrldeCrypt($id);
        $commissioneparticipant = CommissionParticipantEvaluationOffre::where('id_commission_evaluation_offre',$id)->first();

        if($request->action =="Valider"){
            if(isset($commissioneparticipant)){
                $commissioneparticipant->flag_statut_valider_commission_evaluation_offre_participant = true;
                $commissioneparticipant->update();
                return redirect('traitementcommissionevaluationoffres')->with('success', 'Succès : Validation effectuée avec succès ');
            }
        }

        if($request->action =="Enregistrer"){
            foreach($request->note_operations as $key=>$note_operation){
                $entreprise = Entreprises::find($key);
                foreach ($note_operation as $key_sous_critere=>$note_sous_critere) {
                    $notation = new NotationCommissionEvaluationOffreTech();
                    $notation->id_commission_evaluation_offre =$id;
                    $notation->id_sous_critere_evaluation_offre_tech = intval($key_sous_critere);
                    $notation->note_notation_commission_evaluation_offre_tech = intval($note_sous_critere[0]);
                    $notation->id_user_notation_commission_evaluation_offre =Auth::user()->id;
                    $notation->id_operateur =$key;
                    $notation->flag_notation_commission_evaluation_offre_tech = true;

                    //Vérification sur la note entrée
                    $note_souscritere = OffreTechCommissionEvaluationOffre::where('id_commission_evaluation_offre',$id)
                        ->where('id_sous_critere_evaluation_offre_tech',intval($key_sous_critere))
                        ->first();

                    if(!isset($note_sous_critere[0])){
                        return redirect('traitementcommissionevaluationoffres/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(4).'/edit')->with('error', "Erreur : La note du sous-critère ".
                            @$note_souscritere->souscritereevaluationoffretech->libelle_sous_critere_evaluation_offre_tech. " de l'entreprise ".$entreprise->raison_social_entreprises." est requise ");
                    }

                    if(intval($note_sous_critere[0]) > $note_souscritere->note_offre_tech_commission_evaluation_offre){
                        return redirect('traitementcommissionevaluationoffres/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(4).'/edit')->with('error', "Erreur : La note du sous-critère ".
                            @$note_souscritere->souscritereevaluationoffretech->libelle_sous_critere_evaluation_offre_tech. " de l'entreprise ".$entreprise->raison_social_entreprises." est incorrecte ");
                    }

                    $note_exist = NotationCommissionEvaluationOffreTech::where('id_commission_evaluation_offre',$id)
                        ->where('id_sous_critere_evaluation_offre_tech',intval($key_sous_critere))
                        ->where('id_operateur',intval($key))
                        ->first();

                    if(isset($note_exist)){
                        $note_exist->note_notation_commission_evaluation_offre_tech = intval($note_sous_critere[0]);
                        $note_exist->update();
                    }else{
                        $notation->save();
                    }
                }
            }
            return redirect('traitementcommissionevaluationoffres/'.Crypt::UrlCrypt($id).'/'.Crypt::UrlCrypt(4).'/edit')->with('success', 'Succès : Enregistrement effectué avec succès ');
        }
    }
}
