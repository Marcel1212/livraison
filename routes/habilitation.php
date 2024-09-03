<?php

use App\Http\Controllers\Habilitation\DemandeHabilitationController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth']], function () {

    Route::group(['middleware' => ['can:demandehabilitation-index']], function () {
        Route::get('demandehabilitation/{id}/delete', [DemandeHabilitationController::class, 'delete'])->name('demandehabilitation.delete');
        Route::get('demandehabilitation/{id}/{id1}/edit', [DemandeHabilitationController::class, 'edit'])->name('demandehabilitation.edit');
        Route::put('demandehabilitation/{id}/{id1}/update', [DemandeHabilitationController::class, 'update'])->name('demandehabilitation.update');
        Route::get('demandehabilitation/index', [DemandeHabilitationController::class, 'index'])->name('demandehabilitation.index');
        Route::get('demandehabilitation', [DemandeHabilitationController::class, 'index'])->name('demandehabilitation');
        Route::get('demandehabilitation/create', [DemandeHabilitationController::class, 'create'])->name('demandehabilitation.create');
        Route::post('demandehabilitation/store', [DemandeHabilitationController::class, 'store'])->name('demandehabilitation.store');
        Route::get('demandehabilitation/{id}/show', [DemandeHabilitationController::class, 'show'])->name('demandehabilitation.show');
        Route::get('demandehabilitation/{id}/delete', [DemandeHabilitationController::class, 'delete'])->name('demandehabilitation.delete');
        Route::get('demandehabilitation/{id}/deleteapf', [DemandeHabilitationController::class, 'deleteadh'])->name('demandehabilitation.deleteadh');
	});

});
