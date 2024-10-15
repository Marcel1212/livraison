<div class="container">
    <h1>Commentaires</h1>
    <ul class="timeline">
        @foreach($commentaires as $commentaire)
        <li class="timeline-item pb-4 border-left-dashed {{ $commentaire->flag_traitement_par_critere_commentaire == true ? 'timeline-item-success' : 'timeline-item-danger' }}">
            <div class="timeline-header border-bottom mb-3">
                <h6>{{ $commentaire->name }} {{ $commentaire->prenom_users }}  ({{ $commentaire->profil }})</h6>
                <span class="text-muted">Critère: {{ $commentaire->libelle_critere_evaluation }}</span>
            </div>
            <div class="d-flex justify-content-between flex-wrap mb-2">
                <div class="row">
                    <div>
                        <span>Observation : {{ $commentaire->commentaire_critere }}</span>
                    </div>
                    <div>
                        <span class="{{ $commentaire->flag_traitement_par_critere_commentaire == false ? 'badge bg-label-danger' : '' }}">
                            Traité le {{ $commentaire->created_at->format('d/m/Y') }}
                        </span>
                    </div>
                </div>
            </div>
        </li>
        @endforeach
    </ul>
</div>
