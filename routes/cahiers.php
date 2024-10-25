<?php

use App\Http\Controllers\Cahiers\CahierPlansProjetsController;
use App\Http\Controllers\Comites\TraitementComitesTechniquesController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth']], function () {

    Route::group(['middleware' => ['can:cahierplansprojets-index']], function () {

        Route::get('cahierplansprojets/{id}/delete', [CahierPlansProjetsController::class, 'delete'])->name('cahierplansprojets.delete');
        Route::get('cahierplansprojets/{id}/{id1}/edit', [CahierPlansProjetsController::class, 'edit'])->name('cahierplansprojets.edit');
        Route::put('cahierplansprojets/{id}/{id1}/update', [CahierPlansProjetsController::class, 'update'])->name('cahierplansprojets.update');
        Route::get('cahierplansprojets/index', [CahierPlansProjetsController::class, 'index'])->name('cahierplansprojets.index');
        Route::get('cahierplansprojets', [CahierPlansProjetsController::class, 'index'])->name('cahierplansprojets');
        Route::get('cahierplansprojets/create', [CahierPlansProjetsController::class, 'create'])->name('cahierplansprojets.create');
        Route::post('cahierplansprojets/store', [CahierPlansProjetsController::class, 'store'])->name('cahierplansprojets.store');
        Route::get('cahierplansprojets/{id}/show', [CahierPlansProjetsController::class, 'show'])->name('cahierplansprojets.show');
        Route::get('cahierplansprojets/{id}/etatpf', [CahierPlansProjetsController::class, 'etatpf'])->name('cahierplansprojets.etatpf');
        Route::get('cahierplansprojets/{id}/etathab', [CahierPlansProjetsController::class, 'etathab'])->name('cahierplansprojets.etathab');
        Route::get('cahierplansprojets/{id}/etatpe', [CahierPlansProjetsController::class, 'etatpe'])->name('cahierplansprojets.etatpe');
        Route::get('cahierplansprojets/{id}/etatprf', [CahierPlansProjetsController::class, 'etatprf'])->name('cahierplansprojets.etatprf');
        Route::get('cahierplansprojets/{id}/{id2}/agrement', [CahierPlansProjetsController::class, 'agrement'])->name('cahierplansprojets.agrement');
        Route::get('cahierplansprojets/{id}/{id2}/{id3}/editer', [CahierPlansProjetsController::class, 'editer'])->name('cahierplansprojets.editer');
        Route::post('cahierplansprojets/{id}/{id2}/{id3}/agrementupdate', [CahierPlansProjetsController::class, 'agrementupdate'])->name('cahierplansprojets.agrementupdate');

    });



});
