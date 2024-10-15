<?php
    //dd($id);
?>
<div class="container">
    <h5 class="mb-4">Commentaires</h5>
    <ul class="timeline pt-3">
        @foreach($commentaires as $res)
            <li class="timeline-item pb-4 timeline-item-{{ $res->flag_traitement_par_critere_commentaire ? 'success' : 'danger' }} border-left-dashed">
                <span class="timeline-indicator-advanced timeline-indicator-{{ $res->flag_traitement_par_critere_commentaire ? 'success' : 'danger' }}">
                    <i class="ti ti-send rounded-circle scaleX-n1-rtl"></i>
                </span>
                <div class="timeline-event">
                    <div class="timeline-header border-bottom mb-3">
                        <h6 class="mb-0">{{ $res->name }} {{ $res->prenom_users }} ({{ $res->profil }})</h6>
                        <span class="text-muted"><strong>Critère : {{ $res->libelle_critere_evaluation }}</strong></span>
                    </div>
                    <div class="d-flex justify-content-between flex-wrap mb-2">
                        <div>
                            <span>Observation : {{ $res->commentaire_critere }}</span>
                        </div>
                        <div>
                            <span class="{{ $res->flag_traitement_par_critere_commentaire == false ? 'badge bg-label-danger' : '' }}">Traité le {{ $res->datej }}</span>
                        </div>
                        @if($res->flag_traitement_par_critere_commentaire == false)
                            @if($res->flag_traite_par_user_conserne != true)
                                <form method="POST" action="{{ url('/') }}/traitementcomitetechniques/{{ \App\Helpers\Crypt::UrlCrypt($id) }}/{{ \App\Helpers\Crypt::UrlCrypt($iddemande) }}/{{ \App\Helpers\Crypt::UrlCrypt($idetape) }}/comitetechnique/update/habilitation">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="id_traitement_par_critere_commentaire" value="{{ $res->id_traitement_par_critere_commentaire }}">
                                    <div class="row">
                                        <div class="col-md-4 col-12">
                                            <label class="form-label">Statut</label>
                                            <select class="select2 form-select" name="flag_traitement_par_critere_commentaire_traiter">
                                                <option value="">-----------</option>
                                                <option value="true">Prise en compte</option>
                                                <option value="false">Pas prise en compte</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <label class="form-label">Réponse</label>
                                            <textarea class="form-control form-control-sm" name="commentaire_reponse" rows="6"></textarea>
                                        </div>
                                        <div class="col-md-2 col-12">
                                            <br />
                                            <button type="submit" name="action" value="Traiter_action_formation_valider_reponse" class="btn btn-warning btn-sm">Traité</button>
                                        </div>
                                    </div>
                                </form>
                            @else
                                <div>
                                    <span>Statut : {{ $res->flag_traitement_par_critere_commentaire_traiter ? 'Prise en compte' : 'Pas prise en compte' }}</span>
                                </div>
                                <div>
                                    <span>Réponse : {{ $res->commentaire_reponse }}</span>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
</div>

