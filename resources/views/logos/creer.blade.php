@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Configuration')
    @php($titre='Liste des paramètres généraux')
    @php($soustitre='Ajouter un paramètre')
    @php($lien='parametresysteme')

    <h5 class="py-2 mb-1">
        <span class="text-muted fw-light"> <i
                class="ti ti-home"></i>  Accueil / {{$Module}} / {{$titre}} / </span> {{$soustitre}}
    </h5>



        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <div class="alert-body">
                    {{ $message }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif


            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{$soustitre}} </h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" class="form" action="{{ route('creerparametresysteme') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">

                                    <div class="col-md-6 col-12">
                                        <div class="mb-1">
                                            <label>Titre </label>
                                            <input type="text" name="titre_logo" id="titre_logo"
                                                   class="form-control form-control-sm"
                                                   placeholder="Titre">
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="mb-1">
                                            <label>Types valeur </label>
                                            <select name="valeur" id="smallSelect" class="form-select form-select-sm">
                                                <option value="">-- Sélectionner --</option>
                                                <option value="LOGO">LOGO</option>
                                                <option value="EMAIL">EMAIL</option>
                                                <option value="CONTACT">CONTACT</option>
                                                <option value="RESEAUX SOCIAUX">RESEAUX SOCIAUX</option>
                                                <option value="HEURE OUVERTURE">HEURE OUVERTURE</option>
                                                <option value="LOCALISATION">LOCALISATION</option>
                                                <option value="CONTACT INFO">CONTACT INFO</option>
                                                <option value="MAP LATITUDE">MAP LATITUDE</option>
                                                <option value="MAP LONGUEUR">MAP LONGUEUR</option>
                                                <option value="NEWSLETTER">NEWSLETTER</option>
                                                <option value="COULEUR MENU HAUT">COULEUR</option>
                                                <option value="IMAGE ACCEUIL">IMAGE ACCEUIL</option>
                                                <option value="IMAGE DASHBORD">IMAGE DASHBORD</option>
                                                <option value="SITEVITRINE">ACTIVE LE SITE VITIRNE</option>
                                            </select>
                                              </div>
                                    </div>


                                    <div class="col-md-6 col-12">
                                        <div class="mb-1">
                                            <label>Fichier </label><br>

                                            <input type="file" class="form-control form-control-sm" placeholder="ajouter un  fichier" name="logo_logo"  />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="mb-1">
                                            <label>Statut </label><br>
                                            <input type="checkbox" class="form-check-input" name="flag_logo"
                                                   id="colorCheck1">
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="mb-1">
                                            <label>Valeur du mot clé </label>
                                            <textarea class="form-control form-control-sm"  name="mot_cle" id="mot_cle" rows="6"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-12" align="right">
                                        <hr>
                                        <button type="submit"
                                                class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                                            Enregistrer
                                        </button>
                                        <a class="btn btn-sm btn-outline-secondary waves-effect"
                                           href="/{{$lien }}">
                                            Retour</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>





@endsection















