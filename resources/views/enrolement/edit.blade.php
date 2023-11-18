@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='DEMANDE ENROLEMENT')
    @php($titre='Liste des demandes d\'enrolements')
    @php($soustitre='Traitement de demande d\'enrolement')
    @php($lien='enrolement')


    <script type="text/javascript">

    function changeFunc() {
        var selectBox = document.getElementById("id_statut_operation");
        var selectedValue = selectBox.options[selectBox.selectedIndex].value;
       // alert(selectedValue);
        if (selectedValue==1){
            document.getElementById("id_motif").disabled = true;
            document.getElementById("rejeter").disabled = true;
            document.getElementById("valider").disabled = false;
        }else{
            document.getElementById("id_motif").disabled = false;
            document.getElementById("rejeter").disabled = false;
            document.getElementById("valider").disabled = true;
        }

    }

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
                @if($errors->any())
                                  @foreach ($errors->all() as $error)
                                      <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <div class="alert-body">
                                            {{ $error }}
                                        </div>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                      </div>
                                  @endforeach
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
                                    <form method="POST" class="form" action="{{ route($lien.'.update',\App\Helpers\Crypt::UrlCrypt($demandeenrole->id_demande_enrolement)) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Localite </label>
                                                    <input type="text" 
                                                           class="form-control form-control-sm" value="{{$demandeenrole->localite->libelle_localite}}"
                                                           disabled="disabled">
                                                </div>
                                            </div>                                            
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Centre impot </label>
                                                    <input type="text" 
                                                           class="form-control form-control-sm" value="{{$demandeenrole->centreImpot->libelle_centre_impot}}"
                                                           disabled="disabled">
                                                </div>
                                            </div>                                            
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Activité</label>
                                                    <input type="text" 
                                                           class="form-control form-control-sm" value="{{$demandeenrole->activite->libelle_activites}}"
                                                           disabled="disabled">
                                                </div>
                                            </div>                                            
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>NCC </label>
                                                    <input type="text" 
                                                           class="form-control form-control-sm" value="{{$demandeenrole->ncc_demande_enrolement}}"
                                                           disabled="disabled">
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Raison sociale </label>
                                                    <input type="text" 
                                                           class="form-control form-control-sm" value="{{$demandeenrole->raison_sociale_demande_enroleme}}"
                                                           disabled="disabled">
                                                </div>
                                            </div>                                            
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Numero CNPS </label>
                                                    <input type="text" 
                                                           class="form-control form-control-sm" value="{{$demandeenrole->numero_cnps_demande_enrolement}}"
                                                           disabled="disabled">
                                                </div>
                                            </div>                                            
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>RCCM </label>
                                                    <input type="text" 
                                                           class="form-control form-control-sm" value="{{$demandeenrole->rccm_demande_enrolement}}"
                                                           disabled="disabled">
                                                </div>
                                            </div>                                            
                                            
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Indicatif </label>
                                                    <input type="text" 
                                                           class="form-control form-control-sm" value="{{$demandeenrole->pay->indicatif}}"
                                                           disabled="disabled">
                                                </div>
                                            </div>                                            
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Telephone </label>
                                                    <input type="text" 
                                                           class="form-control form-control-sm" value="{{$demandeenrole->tel_demande_enrolement}}"
                                                           disabled="disabled">
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Email </label>
                                                    <input type="text" 
                                                           class="form-control form-control-sm" value="{{$demandeenrole->email_demande_enrolement}}"
                                                           disabled="disabled">
                                                </div>
                                            </div>                                             
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Date de demande </label>
                                                    <input type="text" 
                                                           class="form-control form-control-sm" value="{{$demandeenrole->date_depot_demande_enrolement}}"
                                                           disabled="disabled">
                                                </div>
                                            </div>                                             
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Date de traitement </label>
                                                    <input type="text" 
                                                           class="form-control form-control-sm" value="{{$demandeenrole->date_traitement_demande_enrolem}}"
                                                           disabled="disabled">
                                                </div>
                                            </div>                                            
                                            
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Pièce DFE </label>
                                                            <span class="badge bg-secondary"><a target="_blank"
                                                            onclick="NewWindow('{{ asset("/pieces/piece_dfe_demande_enrolement/". $demandeenrole->piece_dfe_demande_enrolement)}}','',screen.width/2,screen.height,'yes','center',1);">
                                                            Voir la pièce  </a> </span>
                                                </div>
                                            </div>                                            
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Pièce RCCM </label>
                                                                                                        
                                                    <span class="badge bg-secondary"><a target="_blank"
                                                            onclick="NewWindow('{{ asset("/pieces/piece_rccm_demande_enrolement/". $demandeenrole->piece_rccm_demande_enrolement)}}','',screen.width/2,screen.height,'yes','center',1);">
                                                            Voir la pièce  </a> </span>
                                                </div>
                                            </div>                                            
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Pièce attestation immatriculation </label>
                                                     
                                                            <span class="badge bg-secondary"><a target="_blank"
                                                        onclick="NewWindow('{{ asset("/pieces/piece_attestation_immatriculati/". $demandeenrole->piece_attestation_immatriculati)}}','',screen.width/2,screen.height,'yes','center',1);">
                                                            Voir la pièce  </a> </span>
                                                </div>
                                            </div>

                                            <hr>
                                            
                                            <?php if($demandeenrole->flag_recevablilite_demande_enrolement == true){?>
                                               
                                                <div class="col-md-6 col-12">
                                                    <label class="form-label" for="billings-country">Motif de recevabilite</label>
                                                    
                                                    <input type="text" 
                                                            class="form-control form-control-sm" value="{{@$demandeenrole->motif1->libelle_motif}}"
                                                            disabled="disabled">
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="mb-1">
                                                        <label>Commentaire recevabilite: </label>
                                                        <textarea class="form-control form-control-sm"  name="commentaire_recevable_demande_enrolement" id="commentaire_recevable_demande_enrolement" rows="6" disabled="disabled">{{@$demandeenrole->commentaire_recevable_demande_enrolement}}</textarea>
                                                    </div>
                                                </div>

                 
                                                <div class="col-md-6 col-12">
                                                    <label class="form-label" for="billings-country">Motif de validation</label>
                                                    <?php if($demandeenrole->flag_traitement_demande_enrolem != true){ ?>
                                                        <select class="form-select" data-allow-clear="true" name="id_motif" id="id_motif">
                                                            <?= $motif; ?>
                                                        </select>
                                                    <?php }else{ ?>
                                                        <input type="text" 
                                                            class="form-control form-control-sm" value="{{@$demandeenrole->motif->libelle_motif}}"
                                                            disabled="disabled">                                                    
                                                    <?php } ?>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="mb-1">
                                                        <label>Commentaire validation:</label>
                                                        <textarea class="form-control form-control-sm"  name="commentaire_demande_enrolement" id="commentaire_demande_enrolement" rows="6" >{{@$demandeenrole->commentaire_demande_enrolement}}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-12" align="right">
                                                    <hr>
                                                    <?php if($demandeenrole->flag_traitement_demande_enrolem != true){ ?>
                                                    <button type="submit" name="action" value="Valider"
                                                            class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light" id="valider">
                                                        Valider
                                                    </button>                                                
                                                    <button type="submit" name="action" value="Rejeter"
                                                            class="btn btn-sm btn-danger me-1 waves-effect waves-float waves-light" id="rejeter">
                                                        rejeter
                                                    </button>
                                                    <?php } ?>
                                                    <a class="btn btn-sm btn-outline-secondary waves-effect"
                                                    href="/{{$lien }}">
                                                        Retour</a>
                                                </div>
                                            <?php }elseif($demandeenrole->flag_recevablilite_demande_enrolement == false and $demandeenrole->flag_recevablilite_demande_enrolement != null){ ?>
                                                <div class="col-md-6 col-12">
                                                    <label class="form-label" for="billings-country">Motif de recevabilite</label>
                                                    
                                                    <input type="text" 
                                                            class="form-control form-control-sm" value="{{@$demandeenrole->motif1->libelle_motif}}"
                                                            disabled="disabled">
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="mb-1">
                                                        <label>Commentaire recevabilite: </label>
                                                        <textarea class="form-control form-control-sm"  name="commentaire_recevable_demande_enrolement" id="commentaire_recevable_demande_enrolement" rows="6" disabled="disabled">{{@$demandeenrole->commentaire_recevable_demande_enrolement}}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-12" align="right">
                                                    <hr>

                                                    <a class="btn btn-sm btn-outline-secondary waves-effect"
                                                    href="/{{$lien }}">
                                                        Retour</a>
                                                </div>
                                            <?php }else{ ?>

                                                <div class="col-md-6 col-12">
                                                    <label class="form-label" for="billings-country">Motif de recevabilite</label>
                                                    
                                                        <select class="form-select" data-allow-clear="true" name="id_motif_recevable" id="id_motif_recevable">
                                                            <?= $motif; ?>
                                                        </select>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="mb-1">
                                                        <label>Commentaire recevabilite: </label>
                                                        <textarea class="form-control form-control-sm"  name="commentaire_recevable_demande_enrolement" id="commentaire_recevable_demande_enrolement" rows="6">{{@$demandeenrole->commentaire_recevable_demande_enrolement}}</textarea>
                                                    </div>
                                                </div>

                                                <div class="col-12" align="right">
                                                <hr>
                                                    <button type="submit" name="action" value="Recevable"
                                                            class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light" >
                                                        Recevable
                                                    </button>                                                
                                                    <button type="submit" name="action" value="NonRecevable"
                                                            class="btn btn-sm btn-danger me-1 waves-effect waves-float waves-light" >
                                                        Non recevable
                                                    </button>
                                                    <a class="btn btn-sm btn-outline-secondary waves-effect"
                                                    href="/{{$lien }}">
                                                        Retour</a>
                                                </div>
                                           <?php } ?>
                                        </div>
                                    </form>
                                    </div>
                </div>
            </div>
        </div>
    <!-- END: Content-->

@endsection

