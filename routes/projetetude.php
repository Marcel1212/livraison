<?php

use App\Http\Controllers\AffectationProjetEtudeController;
use App\Http\Controllers\ProjetEtudeController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth']], function () {
    //Demande projet etude
    Route::get('projetetude', [ProjetEtudeController::class, 'index'])->name('projetetude');
    Route::get('projetetude/index', [ProjetEtudeController::class, 'index'])->name('projetetude.index');
    Route::get('projetetude/create', [ProjetEtudeController::class, 'create'])->name('projetetude.create');
    Route::post('projetetude/store', [ProjetEtudeController::class, 'store'])->name('projetetude.store');
    Route::get('projetetude/{id}/{id_etape}/edit', [ProjetEtudeController::class, 'edit'])->name('projetetude.edit');
    Route::put('projetetude/{id}/{id_etape}/update', [ProjetEtudeController::class, 'update'])->name('projetetude.update');
    Route::get('projetetude/{id}/{id_piece_projet}/deletefpe', [ProjetEtudeController::class, 'deletefpe'])->name('projetetude.deletefpe');

    //Affectation
    Route::get('affectationprojetetude', [AffectationProjetEtudeController::class, 'index'])->name('affectationprojetetude');
    Route::get('affectationprojetetude/index', [AffectationProjetEtudeController::class, 'index'])->name('affectationprojetetude.index');
    Route::get('affectationprojetetude/{id}/{id_etape}/edit', [AffectationProjetEtudeController::class, 'edit'])->name('affectationprojetetude.edit');
    Route::put('affectationprojetetude/{id}/update', [AffectationProjetEtudeController::class, 'update'])->name('affectationprojetetude.update');



});
