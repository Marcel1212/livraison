@extends('layouts.backLayout.designadmin')

@section('content')

    @php($Module='DEMANDE ENROLEMENT')
    @php($titre='Liste des demandes d\'enrolements')
    @php($soustitre='Traitement de demande d\'enrolement')
    @php($lien='enrolement')


    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper ">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">{{$soustitre}}</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">{{$Module}}</a></li>
                                    <li class="breadcrumb-item"><a href="/{{$lien}}">{{$titre}}</a></li>
                                    <li class="breadcrumb-item active">{{$soustitre}}  </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="content-body">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <div class="alert-body">
                            {{ $message }}
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <section id="multiple-column-form">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{$soustitre}} </h4>
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
                                                    <label>Piece DFE </label>
                                                    <a class="btn  btn-sm btn-info waves-effect" target="_blank"
                                                        onclick="NewWindow('{{ asset("/pieces/piece_dfe_demande_enrolement/". $demandeenrole->piece_dfe_demande_enrolement)}}','',screen.width/2,screen.height,'yes','center',1);">
                                                            Voir piece  </a>
                                                </div>
                                            </div>                                            
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Piece RCCM </label>
                                                    <a class="btn  btn-sm btn-warning waves-effect" target="_blank"
                                                        onclick="NewWindow('{{ asset("/pieces/piece_rccm_demande_enrolement/". $demandeenrole->piece_rccm_demande_enrolement)}}','',screen.width/2,screen.height,'yes','center',1);">
                                                            Voir piece  </a>                                                    

                                                </div>
                                            </div>                                            
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Piece attestation immatriculation </label>
                                                    <a class="btn  btn-sm btn-primary waves-effect" target="_blank"
                                                        onclick="NewWindow('{{ asset("/pieces/piece_attestation_immatriculati/". $demandeenrole->piece_attestation_immatriculati)}}','',screen.width/2,screen.height,'yes','center',1);">
                                                            Voir piece  </a>                                                     

                                                </div>
                                            </div>

                                            <hr>
                                            <hr>

                                            <div class="col-md-4">
                                                <label class="form-label" for="billings-country">Statut</label>
                                                <?php if($demandeenrole->flag_traitement_demande_enrolem != true){ ?>
                                                    <select  class="form-select" data-allow-clear="true" name="id_statut_operation">
                                                        <?= $statutoperation; ?>
                                                    </select>
                                                <?php }else{ ?>
                                                    <input type="text" 
                                                           class="form-control form-control-sm" value="{{@$demandeenrole->statutOperation->libelle_statut_operation}}"
                                                           disabled="disabled">                                                    
                                                <?php } ?>                                                    
                                            </div>                 
                                            <div class="col-md-4">
                                                <label class="form-label" for="billings-country">Motif</label>
                                                <?php if($demandeenrole->flag_traitement_demande_enrolem != true){ ?>
                                                    <select class="form-select" data-allow-clear="true" name="id_motif">
                                                        <?= $motif; ?>
                                                    </select>
                                                <?php }else{ ?>
                                                    <input type="text" 
                                                           class="form-control form-control-sm" value="{{@$demandeenrole->motif->libelle_motif}}"
                                                           disabled="disabled">                                                    
                                                <?php } ?>
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="mb-1">
                                                    <label>Commentaire </label>
                                                    <textarea class="form-control form-control-sm"  name="commentaire_demande_enrolement" id="commentaire_demande_enrolement" rows="6">{{@$demandeenrole->commentaire_demande_enrolement}}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-12" align="right">
                                                <hr>
                                                <?php if($demandeenrole->flag_traitement_demande_enrolem != true){ ?>
                                                <button type="submit" name="action" value="Valider"
                                                        class="btn btn-sm btn-success me-1 waves-effect waves-float waves-light">
                                                    Valider
                                                </button>                                                
                                                <button type="submit" name="action" value="Rejeter"
                                                        class="btn btn-sm btn-danger me-1 waves-effect waves-float waves-light">
                                                    rejeter
                                                </button>
                                                <?php } ?>
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
                </section>
            </div>
        </div>
    </div>
    <!-- END: Content-->

@endsection

