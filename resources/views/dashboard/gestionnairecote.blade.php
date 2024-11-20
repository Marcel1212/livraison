<?php

use App\Helpers\Menu;
use App\Helpers\AnneeExercice;

$anneexercice = AnneeExercice::get_annee_exercice();
//dd($anneexercice);
$anneexerciceDebut = Menu::dateEnFrancais(@$anneexercice->date_debut_periode_exercice);
$anneexerciceFin = Menu::dateEnFrancais(@$anneexercice->date_fin_periode_exercice);

?>
<div class="col-12 col-md-4 ps-md-3 ps-lg-4 pt-3 pt-md-0">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <div>
                <h5 class="mb-2">Nombre de livraisons </h5>
            </div>
            {{-- <div class="time-spending-chart">
                <?php if (isset($anneexercice->id_periode_exercice)){ ?>
                <h4 class="mb-2">
                    <span class="text-muted">Du</span>
                    <span class="badge bg-label-success">{{ ucfirst($anneexerciceDebut) }} </span><br>
                    <span class="text-muted">au </span>
                    <span class="badge bg-label-danger"> {{ ucfirst($anneexerciceFin) }}</span>
                </h4>
                <?php if (!empty($anneexercice->date_prolongation_periode_exercice)){ ?>
                <h3 class="mb-2">
                    <span class="text-muted">Prolongée jusqu'au </span>
                    <span class="badge bg-label-success">{{ $anneexercice->date_prolongation_periode_exercice }} </span>
                </h3>
                <?php } ?>
                <?php } else{ ?>
                <h3 class="mb-2">
                    <span class="text-danger mb-0">{{ $anneexercice }}</span>
                </h3>
                <?php } ?>

            </div> --}}
        </div>
    </div>
</div>
