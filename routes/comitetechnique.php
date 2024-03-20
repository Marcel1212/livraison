<?php

use App\Http\Controllers\Comites\ComitesTechniquesController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth']], function () {

    Route::group(['middleware' => ['can:comitetechniques-index']], function () {

        Route::get('comitetechniques', [ComitesTechniquesController::class, 'index'])->name('comitetechniques');
        Route::get('comitetechniques/create', [ComitesTechniquesController::class, 'create'])->name('comitetechniques.create');
        Route::post('comitetechniques/store', [ComitesTechniquesController::class, 'store'])->name('comitetechniques.store');
        Route::get('comitetechniques/{id}/show', [ComitesTechniquesController::class, 'show'])->name('comitetechniques.show');
        Route::get('comitetechniques/{id}/{id2}/{id3}/cahier', [ComitesTechniquesController::class, 'cahier'])->name('comitetechniques.cahier');
        Route::get('comitetechniques/{id}/{id2}/{id3}/editer', [ComitesTechniquesController::class, 'editer'])->name('comitetechniques.editer');
        Route::post('comitetechniques/{id}/{id2}/{id3}/cahierupdate', [ComitesTechniquesController::class, 'cahierupdate'])->name('comitetechniques.cahierupdate');
        Route::put('comitetechniques/{id}/{id1}/update', [ComitesTechniquesController::class, 'update'])->name('comitetechniques.update');
        Route::get('comitetechniques/{id}/{id1}/edit', [ComitesTechniquesController::class, 'edit'])->name('comitetechniques.edit');
        Route::get('comitetechniques/{id}/delete', [ComitesTechniquesController::class, 'delete'])->name('comitetechniques.delete');

    });

});
