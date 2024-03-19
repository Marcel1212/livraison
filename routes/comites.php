<?php

use App\Http\Controllers\Comites\ComitesController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth']], function () {

    Route::group(['middleware' => ['can:comites-index']], function () {

        Route::get('comites', [ComitesController::class, 'index'])->name('comites');
        Route::get('comites/create', [ComitesController::class, 'create'])->name('comites.create');
        Route::post('comites/store', [ComitesController::class, 'store'])->name('comites.store');
        Route::get('comites/{id}/show', [ComitesController::class, 'show'])->name('comites.show');
        Route::get('comites/{id}/{id2}/{id3}/cahier', [ComitesController::class, 'cahier'])->name('comites.cahier');
        Route::get('comites/{id}/{id2}/{id3}/editer', [ComitesController::class, 'editer'])->name('comites.editer');
        Route::post('comites/{id}/{id2}/{id3}/cahierupdate', [ComitesController::class, 'cahierupdate'])->name('comites.cahierupdate');
        Route::put('comites/{id}/{id1}/update', [ComitesController::class, 'update'])->name('comites.update');
        Route::get('comites/{id}/{id1}/edit', [ComitesController::class, 'edit'])->name('comites.edit');

    });

});
