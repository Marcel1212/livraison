<?php

namespace App\Http\Controllers;
use App\Models\TarifLivraison;
use App\Models\Localite;
use App\Helpers\Crypt;
use App\Models\Livraison;
use DB;
//use http\Client;
use GuzzleHttp\Client;
use App\Models\User;
use Image;
use File;
use Carbon\Carbon;
use Auth;
use GuzzleHttp\Psr7\Request as RequestSMS;
use Illuminate\Http\Request;

class TarificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $tarification = TarifLivraison::all();
        //dd($tarification);exit();
        return view('tarification.index', compact('tarification'));
    }
    public function tracking()
    {
        //
        //$tarification = TarifLivraison::all();
        //dd($tarification);exit();
        return view('tarification.tracking');
    }

    public function indexLivraison()
    {
        //
        $user_id = Auth::user()->id;
        $roles = DB::table('users')
                ->join('model_has_roles','users.id','model_has_roles.model_id')
                ->join('roles','model_has_roles.role_id','roles.id')
                ->where([['users.id','=',$user_id]])
                ->first();
            $idroles = $roles->role_id;
        $nomrole = $roles->name ;
        //dd($nomrole); exit();
        if($nomrole == 'GESTIONNAIRE LIVRAISON' ) {
        $livraison = Livraison::where([['flag_valide','=',true]])->get();
        }elseif($nomrole == 'LIVREUR') {
            $livraison = Livraison::where([['id_livreur','=', $user_id]])->get();
        }elseif($nomrole == 'CLIENT'){
            $livraison = Livraison::where([['id_client','=', $user_id]])->get();
        }

        //dd($livraison);exit();
        return view('tarification.indexlivraison', compact('livraison','nomrole'));
    }

    public function indexstatlivreur()
    {
        //
        $chargerHabilitations = DB::table('vue_liste_livreurs')->get();
        $chargerHabilitationsList =  "<option value=''> Selectionnez le livreur </option>";
        foreach ($chargerHabilitations as $comp) {
            $chargerHabilitationsList .= "<option value='" . $comp->id  . "'>" . mb_strtoupper($comp->name) .' '. mb_strtoupper($comp->prenom_users) ." </option>";
        }
        //dd($chargerHabilitationsList);exit();
        return view('tarification.indexstatlivreur', compact('chargerHabilitationsList'));
    }


    public function indexstatperiode()
    {
        //
        $chargerHabilitations = DB::table('vue_liste_livreurs')->get();
        $chargerHabilitationsList =  "<option value=''> Selectionnez le livreur </option>";
        foreach ($chargerHabilitations as $comp) {
            $chargerHabilitationsList .= "<option value='" . $comp->id  . "'>" . mb_strtoupper($comp->name) .' '. mb_strtoupper($comp->prenom_users) ." </option>";
        }
        //dd($chargerHabilitationsList);exit();
        return view('tarification.indexstatperiode', compact('chargerHabilitationsList'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $localites = Localite::where('departement_localite_id', '=', 1)
                ->orderBy('libelle_localite')
                ->get();
        $localite = "<option value=''> Selectionnez une commune </option>";
        foreach ($localites as $comp) {
        $localite .= "<option value='" . $comp->id_localite  . "'>" . $comp->libelle_localite ." </option>";
        }
            //dd($localite);exit();
            return view('tarification.create', compact('localite'));
        //dd($localite); exit();
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $input = $request->all();
        //dd($input); exit();
        $tarification = TarifLivraison::create($input);
        return redirect()->route('traitementlivraisonprix.index')->with('success', 'Tarification ajouté avec succès.');
    }

    public function storelivraison(Request $request)
    {
        //
        $input = $request->all();
        $idcommuneexp = $input['id_commune_exp'];
        $idcommunedest = $input['id_commune_dest'];
        $tarif = TarifLivraison::where([['id_commune_exp','=',$idcommuneexp],['id_commune_dest','=',$idcommunedest]])->first();
        if(isset($tarif)){
            // Tarif en place
            $communeexp = Localite::where([['id_localite','=',$idcommuneexp]])->first();
            $communedest = Localite::where([['id_localite','=',$idcommunedest]])->first();
            $input["prix"] = $tarif->prix;
            Livraison::create($input);
            $id_livraison = Livraison::latest()->first()->id_livraison;
            return view('tarification.prix', compact('tarif', 'input','communeexp','communedest','id_livraison'));
        }else {
            // Vide
            return redirect()->route('livraison')->with('error', 'Livraison pas encore possible pour cette destination.');
        }


        //return redirect()->route('traitementlivraisonprix.index')->with('success', 'Tarification ajouté avec succès.');
    }


    public function  verification(Request $request)
    {
        //

        $input = $request->all();
        $codelivraison = $input["code_livraison"];
        $livraison = Livraison::where([['code_livraison','=',$codelivraison]])->first();
        if($livraison != null){
            if (isset($livraison->id_livreur)){
                $livreur = User::find($livraison->id_livreur);
                //dd($livreur); exit();

            }else{
                $livreur = [];
            }
            return view('tarification.trackingresult', compact('livraison','livreur'));
        }else{

            return redirect()->route('tracking')->with('error', 'Livraison inexistante');
        }
       // dd($livraison); exit();


    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $user_id = Auth::user()->id;
        $roles = DB::table('users')
                ->join('model_has_roles','users.id','model_has_roles.model_id')
                ->join('roles','model_has_roles.role_id','roles.id')
                ->where([['users.id','=',$user_id]])
                ->first();
            $idroles = $roles->role_id;
        $nomrole = $roles->name ;
        //dd($nomrole); exit(); //GESTIONNAIRE LIVRAISON
        $id =  Crypt::UrldeCrypt($id);
        $livraison = Livraison::find($id);
        //dd($livraison); die();

        // recuperation des livreurs
        if($nomrole == 'GESTIONNAIRE LIVRAISON' && $livraison->flag_a_traite == false){
            //dd(Auth::user()->id_service);
            $chargerHabilitations = DB::table('vue_liste_livreurs')->get();
            $chargerHabilitationsList =  "<option value=''> Selectionnez le livreur </option>";
            foreach ($chargerHabilitations as $comp) {
                $chargerHabilitationsList .= "<option value='" . $comp->id  . "'>" . mb_strtoupper($comp->name) .' '. mb_strtoupper($comp->prenom_users) ." </option>";
            }

            $NombreDemandeHabilitation = DB::table('vue_nombre_traitement_livraison')->orderBy('nbre_dossier_en_cours','asc')->get();
        }else{
            $id_charge =  $livraison->id_livreur;
            $chargerHabilitations = DB::table('vue_liste_livreurs')->where([['id','=',$id_charge]])->get();
            if($nomrole == 'CLIENT' && $livraison->flag_a_traite == false){
                $chargerHabilitations = $chargerHabilitations ;
            }else {
                $chargerHabilitations = $chargerHabilitations[0];
            }

            //$chargerHabilitations = [];
            $chargerHabilitationsList = [];
            $NombreDemandeHabilitation = [];
        }
        //dd($chargerHabilitations[0]->name); exit();

        return view('tarification.edit', compact('livraison','nomrole','chargerHabilitationsList','NombreDemandeHabilitation','chargerHabilitations'));

    }


    public function editlivraison(string $id)
    {
        //
        $user_id = Auth::user()->id;
        $roles = DB::table('users')
                ->join('model_has_roles','users.id','model_has_roles.model_id')
                ->join('roles','model_has_roles.role_id','roles.id')
                ->where([['users.id','=',$user_id]])
                ->first();
            $idroles = $roles->role_id;
        $nomrole = $roles->name ;
        //dd($nomrole); exit(); //GESTIONNAIRE LIVRAISON
        $id =  Crypt::UrldeCrypt($id);
        $tariflivraison = TarifLivraison::find($id);
        $idcommuneexp = $tariflivraison->id_commune_exp;
        $idcommunedest = $tariflivraison->id_commune_dest;
        //dd($tariflivraison); die();

        $localites = Localite::where('departement_localite_id', '=', 1)
                            ->orderBy('libelle_localite')
                            ->get();
        $localiteexp = "<option value=''> Selectionnez une commune </option>";
        foreach ($localites as $comp) {
            if ($comp->id_localite == $idcommuneexp){
                $val = 'selected';
            }else {
                $val = '';
            }

        $localiteexp .= "<option value='" . $comp->id_localite  . "'  $val >" . $comp->libelle_localite ." </option>";
        }
        //dd($localiteexp); exit();

        // Dest
        $localitedest = "<option value=''> Selectionnez une commune </option>";
        foreach ($localites as $comp) {
            if ($comp->id_localite == $idcommunedest){
                $val = 'selected';
            }else {
                $val = '';
            }

        $localitedest .= "<option value='" . $comp->id_localite  . "'  $val >" . $comp->libelle_localite ." </option>";
        }

        return view('tarification.editlivraison', compact('localiteexp', 'localitedest', 'tariflivraison'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //

        $data = $request->all();
        $id = Crypt::UrldeCrypt($id);
        if ($request->isMethod('put')) {
            $codelivraisonunique = random_int(100, 200000);
            //dd($indexAleatoire); exit();
            if(isset(Auth::user()->id)){
                $id_client = Auth::user()->id;
            }else {
                $id_client =0;
            }
            $livraison = Livraison::find($id);
            //dd($livraison->numero_exp); exit();
            $livraison->code_livraison = $codelivraisonunique ;
            $livraison->id_client = $id_client ;
            $livraison->flag_valide = true ;
            $livraison->save();
            // Envoie du SMS
            $numeroexpediteur = $livraison->numero_exp ;
            $client = new Client();
            //dd ($client); exit();
            $headers = [
                'User-Agent" => "GuzzleHttp/7',
                'Content-Type' => 'application/json'
              ];
              $body = '{
                "content": "TEST"
              }';
              $request = new RequestSMS('GET', 'https://apis.letexto.com/v1/messages/send?token=bf9d062a9d87b3521c4d7b5e65ee09de&from=LOSSERVICE&to=2250'.$numeroexpediteur.'&content=Bonjour cher client, Votre commande : '.$codelivraisonunique .' a été confirmée. Nous vous assignerons un livreur sous peu pour la prise en charge. Merci pour la confiance ! ', $headers, $body);
              //echo ($request); exit();
              //(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null
              $res = $client->sendAsync($request)->wait();
              //echo $res->getBody();

            //dd($livraison);
            // Generer un code

        }
        //dd($data);

        return view('tarification.validation', compact('livraison'))->with('success', 'Livraison ajouté avec succès. Traitement en cours');
    }

    public function updateprixlivraison(Request $request, string $id)
    {
        //

        $data = $request->all();
        $id = Crypt::UrldeCrypt($id);
        //dd($data);exit();
        if ($request->isMethod('put')) {
            $tariflivraison = TarifLivraison::find($id);
            $tariflivraison->prix = $data['prix'];
            $tariflivraison->id_commune_exp = $data['id_commune_exp'];
            $tariflivraison->id_commune_dest = $data['id_commune_dest'];
            $tariflivraison->save();

        }
        return redirect('traitementlivraisonprix/')
                    ->with('success', 'Prix du trajet modifié avec succes');

    }


    public function updatelivraison(Request $request, string $id)
    {
        //

        $data = $request->all();
        //dd($data);exit();
        $id = Crypt::UrldeCrypt($id);
        //dd($id);exit();
        if ($request->isMethod('put')) {
            //Affectation a un livreur

            if($data['action'] === 'commentaire_livraison'){
                // Recherche de la livraison
                $livraison = Livraison::find($id);
                //dd($livraison);exit();
                // Modification de l'id et du flag
                $livraison ->commentaire_livraison = $data["commentaire_livraison"] ;
                $livraison->save();


                return redirect('livraison')
                ->with('success', 'Commentaire ajouteé avec succes');

        }
            if($data['action'] === 'affecter_livraison'){
                    // Recherche de la livraison
                    $livraison = Livraison::find($id);
                    $livreur = User::find( $data["id_livreur"]);
                    $numerolivreur = $livreur->cel_users ;
                    //dd($livreur);exit();
                    // Modification de l'id et du flag
                    $livraison ->id_livreur = $data["id_livreur"] ;
                    $livraison ->flag_a_traite = true ;
                    $livraison->save();

                    // Envoie du message au client
                    $numeroexpediteur = $livraison->numero_exp ;
                    $codelivraisonunique = $livraison->code_livraison ;

                    $client = new Client();
                    //dd ($client); exit();
                    $headers = [
                    'User-Agent" => "GuzzleHttp/7',
                    'Content-Type' => 'application/json'
                    ];
                    $body = '{
                    "content": "TEST"
                    }';
                    $request = new RequestSMS('GET', 'https://apis.letexto.com/v1/messages/send?token=bf9d062a9d87b3521c4d7b5e65ee09de&from=LOSSERVICE&to=2250'.$numeroexpediteur.'&content=Bonjour cher client, Votre commande : '.$codelivraisonunique .'  est prise en charge par '.$livreur->name .' . Vous pouvez suivre son parcours en temps réel via l’application web. ', $headers, $body);
                    //echo ($request); exit();
                    //(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null
                    $res = $client->sendAsync($request)->wait();
                    //echo $res->getBody();


                    // Envoie du message au livreur
                    $client = new Client();
                    //dd ($client); exit();
                    $headers = [
                        'User-Agent" => "GuzzleHttp/7',
                        'Content-Type' => 'application/json'
                    ];
                    $body = '{
                        "content": "TEST"
                    }';
                    $request = new RequestSMS('GET', 'https://apis.letexto.com/v1/messages/send?token=bf9d062a9d87b3521c4d7b5e65ee09de&from=LOSSERVICE&to=225'.$numerolivreur.'&content=Bonjour '.$livreur->name.', Vous avez une nouvelle commande à prendre en charge : '.$codelivraisonunique .'. Rendez-vous sur l’application web Los Livraison pour consulter les détails et confirmer la prise en charge. ', $headers, $body);
                    //echo ($request); exit();
                    //(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null
                    $res = $client->sendAsync($request)->wait();
                    //echo $res->getBody();


                    return redirect('traitementlivraisonprix/'.Crypt::UrlCrypt($id).'/edit')
                    ->with('success', 'Livraison affecté au livreur avec succès');

            }

            if($data['action'] === 'valider_livraison'){
                // Recherche de la livraison
                $livraison = Livraison::find($id);
                //dd($livraison->localitedest->libelle_localite);exit();
                $livreur = User::find( $livraison->id_livreur);
                $numerolivreur = $livreur->cel_users ;
                // Modification de l'id et du flag
                //$livraison ->id_livreur = $data["id_livreur"] ;
                $livraison ->flag_en_attente = true ;
                $livraison->save();

                // Envoie du message au client
                $numeroexpediteur = $livraison->numero_exp ;
                $codelivraisonunique = $livraison->code_livraison ;

                $client = new Client();
                //dd ($client); exit();
                $headers = [
                'User-Agent" => "GuzzleHttp/7',
                'Content-Type' => 'application/json'
                ];
                $body = '{
                "content": "TEST"
                }';
                $request = new RequestSMS('GET', 'https://apis.letexto.com/v1/messages/send?token=bf9d062a9d87b3521c4d7b5e65ee09de&from=LOSSERVICE&to=2250'.$numeroexpediteur.'&content=Bonjour cher client, Le livreur '. $livreur->name .'   a pris en charge votre commande : '.$codelivraisonunique .' . Votre colis est en route pour être livré à  '.$livraison->localitedest->libelle_localite.'', $headers, $body);
                //echo ($request); exit();
                //(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null
                $res = $client->sendAsync($request)->wait();
                echo $res->getBody();


                // Envoie du message au livreur
                $client = new Client();
                //dd ($client); exit();
                $headers = [
                    'User-Agent" => "GuzzleHttp/7',
                    'Content-Type' => 'application/json'
                ];
                $body = '{
                    "content": "TEST"
                }';
                $request = new RequestSMS('GET', 'https://apis.letexto.com/v1/messages/send?token=bf9d062a9d87b3521c4d7b5e65ee09de&from=LOSSERVICE&to=225'.$numerolivreur.'&content=Bonjour '.$livreur->name.', Vous avez confirmé la prise en charge de la commande : '.$codelivraisonunique .'. Merci de vous rendre à l’adresse indiquée pour récupérer le colis et le livrer. ', $headers, $body);
                //echo ($request); exit();
                //(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null
                $res = $client->sendAsync($request)->wait();


                return redirect('traitementlivraisonprix/'.Crypt::UrlCrypt($id).'/edit')
                ->with('success', 'Livraison confirmé, bonne livraison ! Veuillez vous rendre chez l\'expediteur');

        }
        if($data['action'] === 'valider_reception'){
            // Recherche de la livraison
            $livraison = Livraison::find($id);
            //dd($livraison);exit();
            // Modification de l'id et du flag
            //$livraison ->id_livreur = $data["id_livreur"] ;
            $livraison ->flag_liv_en_cours = true ;
            $livraison->save();


            return redirect('traitementlivraisonprix/'.Crypt::UrlCrypt($id).'/edit')
            ->with('success', 'Validation de la livraison de la commande ! Veuillez vous rendre chez le destinataire');

    }
    if($data['action'] === 'valider_succes_livraison'){
        // Recherche de la livraison
        $livraison = Livraison::find($id);
        $livreur = User::find( $livraison->id_livreur);
        $numerolivreur = $livreur->cel_users ;
        $dateFin = Carbon::now();
        $livraison ->flag_livre = true ;
        $livraison ->date_livraison_effectue = $dateFin  ;
        $livraison->save();

           // Envoie du message au client
           $numeroexpediteur = $livraison->numero_exp ;
           $codelivraisonunique = $livraison->code_livraison ;

           $client = new Client();
           //echo date("H:i:s");
           $now = date("H:i:s");
           //dd($now); exit();

           $headers = [
           'User-Agent" => "GuzzleHttp/7',
           'Content-Type' => 'application/json'
           ];
           $body = '{
           "content": "TEST"
           }';
           $request = new RequestSMS('GET', 'https://apis.letexto.com/v1/messages/send?token=bf9d062a9d87b3521c4d7b5e65ee09de&from=LOSSERVICE&to=2250'.$numeroexpediteur.'&content=Bonjour cher client, Votre commande : '.$codelivraisonunique .' a été livrée avec succès à  '.$now.' . Merci d’avoir choisi notre service ! C’est chap, c’est secu, c’est bien fait. ', $headers, $body);
           //echo ($request); exit();
           //(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null
           $res = $client->sendAsync($request)->wait();
           //echo $res->getBody();


           // Envoie du message au livreur
           $client = new Client();
           //dd ($client); exit();
           $headers = [
               'User-Agent" => "GuzzleHttp/7',
               'Content-Type' => 'application/json'
           ];
           $body = '{
               "content": "TEST"
           }';
           $request = new RequestSMS('GET', 'https://apis.letexto.com/v1/messages/send?token=bf9d062a9d87b3521c4d7b5e65ee09de&from=LOSSERVICE&to=225'.$numerolivreur.'&content=Bonjour '.$livreur->name.', Votre commande: '.$codelivraisonunique .' a été livrée avec succès à '.$now .' . Merci d’avoir choisi notre service ! C’est chap, c’est secu, c’est bien fait.. ', $headers, $body);
           //echo ($request); exit();
           //(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null
           $res = $client->sendAsync($request)->wait();



        return redirect('traitementlivraisonprix/'.Crypt::UrlCrypt($id).'/edit')
        ->with('success', 'Livraison validé avec succes ! Mes felicitations !');

}

        }
        //dd($data);

        return view('tarification.validation', compact('livraison'))->with('success', 'Livraison ajouté avec succès. Traitement en cours');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        //
        //$data = $request->all();
        //dd($data);exit();
        $id = Crypt::UrldeCrypt($id);
        $tarification = TarifLivraison::find($id);
        $tarification->delete();
        return redirect()->route('traitementlivraisonprix.index')->with('success', 'Tarification supprimé avec succès.');


    }
}
