@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='Paramétrage')
    @php($titre='Liste des utilisateurs')
    @php($soustitre='Ajouter un utilisateur')
    @php($lien='users')

    <script type="text/javascript">

        function changeFunc() {
            //alert('code');exit;
            //location.reload();
           // location.href = location.href;
           //document.getElementById("departement").innerHTML = "";
           //document.getElementById("service").innerHTML = "";
            var selectBox = document.getElementById("profiles");
            //var selectedValue = selectBox.options[selectBox.selectedIndex].value;
            let selectedValue = selectBox.options[selectBox.selectedIndex].value;
            const myArray = selectedValue.split("/");
            let profile = myArray[0];
            let code = myArray[1];
            if(code === 'DIR'){
                document.getElementById("direction").disabled = false;
                document.getElementById("departement").disabled = true;
                document.getElementById("departement").style.display = "none";
                document.getElementById("service").disabled = true;
                document.getElementById("service").style.display = "none";
            }else if(code === 'DEPART'){
                document.getElementById("direction").disabled = false;
                document.getElementById("departement").disabled = false;
                document.getElementById("service").disabled = true;
                document.getElementById("service").style.display = "none";
            }else if(code === 'SERV'){
                document.getElementById("direction").disabled = false;
                document.getElementById("departement").disabled = false;
                document.getElementById("service").disabled = false;
            }else{
                document.getElementById("direction").disabled = false;
                document.getElementById("departement").disabled = false;
                document.getElementById("service").disabled = false;
            }

            // alert(selectedValue);
            /*if (selectedValue==3 || selectedValue==1){
                document.getElementById("superfie_lot").disabled = true;
                document.getElementById("type_superficie_lot").disabled = true;
                document.getElementById("montant_lot").disabled = false;
            }else if(selectedValue==2){
                document.getElementById("montant_lot").disabled = true;
                document.getElementById("superfie_lot").disabled = false;
                document.getElementById("type_superficie_lot").disabled = false;
            }else{
                document.getElementById("montant_lot").disabled = false;
                document.getElementById("superfie_lot").disabled = false;
                document.getElementById("type_superficie_lot").disabled = false;
            }*/

        };



    </script>

    <!-- BEGIN: Content-->

            <h5 class="py-2 mb-1">
                    <span class="text-muted fw-light"> <i class="ti ti-home"></i>  Accueil / {{$Module}} / {{$titre}} / </span> {{$soustitre}}
                </h5>

            <div class="content-body">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <div class="alert-body">
                            {{ $message }}
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="row">
                        <!-- Basic Layout -->
                        <div class="col-xxl">
                            <div class="card mb-4">
                                <div class="card-header d-flex align-items-center justify-content-between">
                                    <h5 class="mb-0">{{$titre}}</h5>
                                    <small class="text-muted float-end">

                                    </small>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route($lien.'.store') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-8 col-12">
                                                <div class="mb-1">
                                                    <label>Profil utilisateur</label> <strong style="color: red">(*)</strong>
                                                    <select class="select2 select2-size-sm form-select" name="roles" id="profiles" onchange="changeFunc();" required>
                                                        <?php echo $roles; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Identifiant</label> <strong style="color: red">6 caractères minimum</strong>
                                                    <input type="text" name="login_users" id="login_users"
                                                           class="form-control form-control-sm"
                                                           placeholder="Identifiant" minlength="6"
                                                           required></div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label" for="state">Direction </label> <strong style="color: red">(*)</strong>
                                                <select class="select2 form-select" id="direction" name="id_direction"/>
                                                    <option value='0'>Directions</option>
                                                    @foreach($directions as $direction)
                                                    <option value='{{$direction->id_direction}}'>{{$direction->libelle_direction}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label" for="state">Departement</label>
                                                <select class="select2 form-select" id='departement' name='id_departement'  class="form-control">
                                                    <option value='0'>Departement</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label" for="state">Service</label>

                                                <select class="select2 form-select" id='service' name='id_service' class="form-control" >
                                                    <option value='0'>Service</option>
                                                </select>
                                            </div>

                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Nom </label> <strong style="color: red">(*)</strong>
                                                    <input type="text" name="name" id="name"
                                                           class="form-control form-control-sm" placeholder="Nom"
                                                           required>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Prénoms</label> <strong style="color: red">(*)</strong>
                                                    <input type="text" name="prenom_users" id="prenom_users"
                                                           class="form-control form-control-sm" placeholder="Prénoms">
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Mot de passe</label> <strong style="color: red">6 caractères minimum</strong>
                                                    <input type="password" name="password" id="password"
                                                           class="form-control form-control-sm" minlength="6"
                                                           placeholder="Mot de passe">
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Genre :</label>
                                                    <select name="genre_users" id="genre_users" class="select2 select2-size-sm form-select">
                                                        <option value="Feminin">Feminin</option>
                                                        <option value="Masculin">Masculin</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Email :</label>  <strong style="color: red">(*)</strong>
                                                    <input type="email" name="email" id="email"
                                                           class="form-control form-control-sm" placeholder="Email" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Adresse :</label>
                                                    <input type="text" name="adresse_users" id="adresse_users"
                                                           class="form-control form-control-sm" placeholder="Adresse">
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-12">
                                                <div class="mb-1">
                                                    <label>Cel. :</label>
                                                    <input type="number" name="cel_users" id="cel_users"
                                                           class="form-control form-control-sm"
                                                           placeholder="Ex:  0102030405">
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-12">
                                                <div class="mb-1">
                                                    <label>Tel. :</label>
                                                    <input type="number" name="tel_users" id="tel_users"
                                                           class="form-control form-control-sm"
                                                           placeholder="Ex:  0102030405">
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Antenne :</label> <strong style="color: red">(*)</strong>
                                                    <select class="select2 select2-size-sm form-select" name="num_agce" id="num_agce" required>
                                                        <?php echo $Entite; ?>
                                                    </select></div>
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Statut </label>
                                                    <select name="flag_actif_users" class="select2 select2-size-sm form-select">
                                                        <option value=true>Actif</option>
                                                        <option value=false>Inactif</option>
                                                    </select>


                                                </div>
                                            </div>
                                            <div class="col-12" align="right">
                                                <hr>
                                                <button type="submit"
                                                        class="btn btn-primary me-1 waves-effect waves-float waves-light">
                                                    Enregistrer
                                                </button>
                                                <a class="btn btn-outline-secondary waves-effect" href="/{{$lien }}">
                                                    Retour</a>
                                            </div>
                                        </div>
                                    </form>
                                    </div>
                </div>
            </div>
        </div>
    <!-- END: Content-->

<!--<script language="JavaScript" type="text/javascript">

</script>-->

@endsection








