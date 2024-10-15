<?php
    //dd($id);
?>
<div class="container">
    <h5 class="mb-4">Avis global du comite technique</h5>
    <form method="POST" action="{{ url('/') }}/avisglobalcomitetechnique/{{ \App\Helpers\Crypt::UrlCrypt($id) }}/{{ \App\Helpers\Crypt::UrlCrypt($iddemande) }}/{{ \App\Helpers\Crypt::UrlCrypt($idetape) }}/update">
        @csrf
        @method('PUT')
            <div class="row">

                <div class="col-md-4 col-12">
                    <label>Type processus</label>
                    <input type="text" class="form-control form-control-sm" value="<?php
                                                if ($demande->code_processus == 'PF') {echo 'PLAN DE FORMATION';}
                                                if ($demande->code_processus == 'PE') {echo 'PROJET ETUDE';}
                                                if ($demande->code_processus == 'PRF') {echo 'PROJET DE FORMATION';}
                                                if ($demande->code_processus == 'HAB') {echo 'HABILITATION';}
                                                                            ?>"  disabled/>
                </div>

                <div class="col-md-4 col-12">
                    <label>Entreprise</label>
                    <input type="text" class="form-control form-control-sm" value="{{ @$demande->raison_sociale }}"  disabled/>
                </div>

                <div class="col-md-4 col-12">
                    <label>Conseiller</label>
                    <input type="text" class="form-control form-control-sm" value="{{ @$demande->nom_conseiller }}"  disabled/>
                </div>

                <div class="col-md-4 col-12">
                    <label>Avis technique <strong style="color:red;">*</strong></label>
                    <select class="select2 form-select @error('id_statut_operation')
                    error
                    @enderror"
                                    data-allow-clear="true" name="id_statut_operation"
                                    id="id_statut_operation"  required>
                        <?php echo $avistechnique; ?>
                    </select>
                    @error('id_statut_operation')
                    <div class=""><label class="error">{{ $message }}</label></div>
                    @enderror
                </div>

                <div class="col-md-4 col-12">
                    <label>Motif <strong style="color:red;">*</strong></label>
                    <select class="select2 form-select @error('id_motif')
                    error
                    @enderror"
                                    data-allow-clear="true" name="id_motif"
                                    id="id_motif"  required>
                        <?php echo $motif; ?>
                    </select>
                    @error('id_motif')
                    <div class=""><label class="error">{{ $message }}</label></div>
                    @enderror
                </div>

                <div class="col-md-4 col-12">
                    <div class="mb-1">
                        <label>Observation </label>
                        <textarea class="form-control form-control-sm"  name="commentaire_agct" id="commentaire_agct" rows="6">{{ @$avisgobal->commentaire_agct }}</textarea>

                    </div>
                </div>

                <div class="col-12" align="right">
                    <hr>
                    <button type="submit"
                            class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light">
                        Enregistrer
                    </button>
                    {{-- <a class="btn btn-sm btn-outline-secondary waves-effect" href="/{{$lien }}">
                        Annuler</a> --}}
                </div>
            </div>
    </form>

</div>

