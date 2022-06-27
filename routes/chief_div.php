<?php

use App\Http\Controllers\ChiefDiv\DashboardController;
use App\Http\Controllers\ChiefDiv\LetterController;
use App\Http\Controllers\ChiefDiv\VerificationStatusController;

Route::group(['prefix' => 'chief_div', 'middleware' => ['role:chief_of_division|chief_of_sub_division|coordinator|personil']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::post('/letter-chief_div/dt', [LetterController::class, 'dt']);
    Route::put('/letter-chief_div/edit/{id}', [LetterController::class, 'update']);
    Route::get('/letter-chief_div/edit/{id}', [LetterController::class, 'show']);
    Route::resource('/letter-chief_div', 'ChiefDiv\LetterController');

    Route::get('/verification', [VerificationStatusController::class, 'index']);

    Route::get('/verification/find', [VerificationStatusController::class, 'find']);

    Route::get('/verification/show/{id}', [VerificationStatusController::class, 'show']);

    Route::get('/download_pdf/{id}', [LetterController::class, 'print']);
    Route::get('/download_all/{id}', [LetterController::class, 'download_all']);
}
);
