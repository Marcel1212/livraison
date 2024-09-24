@if(auth()->user()->can('users-create'))

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
                                                    <label>Profil utilisateur</label> <strong style="color: red">*</strong>
                                                    <select class="select2 select2-size-sm form-select" name="roles" id="profiles" onchange="changeFunc();" required>
                                                        <?php echo $roles; ?>
                                                    </select>
                                                </div>
                                                @error('roles')
                                                <div class=""><label class="error">{{ $message }}</label></div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Identifiant</label> <strong style="color: red">8 caractères minimum</strong>
                                                    <input type="text" name="login_users" id="login_users"
                                                           class="form-control form-control-sm"
                                                           placeholder="Identifiant" minlength="8" value="{{ old('login_users') }}"
                                                           required>
                                                </div>
                                                @error('login_users')
                                                <div class=""><label class="error">{{ $message }}</label></div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label" for="state">Direction </label> <strong style="color: red">*</strong>
                                                <select class="select2 form-select" id="direction" name="id_direction"/>
                                                    <option value='0'>Directions</option>
                                                    @foreach($directions as $direction)
                                                    <option value='{{$direction->id_direction}}'>{{$direction->libelle_direction}}</option>
                                                    @endforeach
                                                </select>
                                                @error('id_direction')
                                                <div class=""><label class="error">{{ $message }}</label></div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label" for="state">Département</label>
                                                <select class="select2 form-select" id='departement' name='id_departement'  class="form-control">
                                                    <option value='0'>Département</option>
                                                </select>
                                                @error('id_departement')
                                                <div class=""><label class="error">{{ $message }}</label></div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label" for="state">Service</label>

                                                <select class="select2 form-select" id='service' name='id_service' class="form-control" >
                                                    <option value='0'>Service</option>
                                                </select>
                                                @error('id_service')
                                                <div class=""><label class="error">{{ $message }}</label></div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Nom </label> <strong style="color: red">*</strong>
                                                    <input type="text" name="name" id="name"
                                                           class="form-control form-control-sm" placeholder="Nom"
                                                           required value="{{ old('name') }}">
                                                </div>
                                                @error('name')
                                                <div class=""><label class="error">{{ $message }}</label></div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Prénoms</label> <strong style="color: red">*</strong>
                                                    <input type="text" name="prenom_users" id="prenom_users"
                                                           class="form-control form-control-sm" placeholder="Prénoms" value="{{ old('prenom_users') }}">
                                                </div>
                                                @error('prenom_users')
                                                <div class=""><label class="error">{{ $message }}</label></div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Mot de passe</label> <strong style="color: red">8 caractères minimum</strong>
                                                    <input type="password" name="password" id="password"
                                                           class="form-control form-control-sm" minlength="8"
                                                           placeholder="Mot de passe" value="{{ old('password') }}">
                                                </div>
                                                @error('password')
                                                <div class=""><label class="error">{{ $message }}</label></div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Genre :</label>
                                                    <select name="genre_users" id="genre_users" class="select2 select2-size-sm form-select">
                                                        <option value="Feminin">Feminin</option>
                                                        <option value="Masculin">Masculin</option>
                                                    </select>
                                                </div>
                                                @error('genre_users')
                                                <div class=""><label class="error">{{ $message }}</label></div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Email :</label>  <strong style="color: red">*</strong>
                                                    <input type="email" name="email" id="email"
                                                           class="form-control form-control-sm" placeholder="Email" required value="{{ old('email') }}">
                                                </div>
                                                @error('email')
                                                <div class=""><label class="error">{{ $message }}</label></div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Adresse :</label>
                                                    <input type="text" name="adresse_users" id="adresse_users"
                                                           class="form-control form-control-sm" placeholder="Adresse" value="{{ old('adresse_users') }}">
                                                </div>
                                                @error('adresse_users')
                                                <div class=""><label class="error">{{ $message }}</label></div>
                                                @enderror
                                            </div>
                                            <div class="col-md-2 col-12">
                                                <div class="mb-1">
                                                    <label>Cel. :</label>
                                                    <input type="number" name="cel_users" id="cel_users"
                                                           class="form-control form-control-sm"
                                                           placeholder="Ex:  0102030405" value="{{ old('cel_users') }}">
                                                </div>
                                                @error('cel_users')
                                                <div class=""><label class="error">{{ $message }}</label></div>
                                                @enderror
                                            </div>
                                            <div class="col-md-2 col-12">
                                                <div class="mb-1">
                                                    <label>Tel. :</label>
                                                    <input type="number" name="tel_users" id="tel_users"
                                                           class="form-control form-control-sm"
                                                           placeholder="Ex:  0102030405" value="{{ old('tel_users') }}">
                                                </div>
                                                @error('tel_users')
                                                <div class=""><label class="error">{{ $message }}</label></div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Antenne :</label> <strong style="color: red">*</strong>
                                                    <select class="select2 select2-size-sm form-select" name="num_agce" id="num_agce" required>
                                                        <?php echo $Entite; ?>
                                                    </select>
                                                </div>
                                                @error('num_agce')
                                                <div class=""><label class="error">{{ $message }}</label></div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Actif </label>
                                                    <select name="flag_actif_users" class="select2 select2-size-sm form-select">
                                                        <option value=true>Actif</option>
                                                        <option value=false>Inactif</option>
                                                    </select>
                                                </div>
                                                @error('flag_actif_users')
                                                <div class=""><label class="error">{{ $message }}</label></div>
                                                @enderror
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
@else
 <script type="text/javascript">
    window.location = "{{ url('/403') }}";//here double curly bracket
</script>
@endif







