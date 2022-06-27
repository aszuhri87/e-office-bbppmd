<?php

 use App\Http\Controllers\Chief\DashboardController;
 use App\Http\Controllers\Chief\LetterController;
 use App\Http\Controllers\Chief\VerificationStatusController;

 Route::group(['prefix' => 'chief', 'middleware' => ['role:chief']], function () {
     Route::get('/dashboard', [DashboardController::class, 'index']);

     Route::post('/letter-chief/dt', [LetterController::class, 'dt']);
     Route::put('/letter-chief/edit/{id}', [LetterController::class, 'update']);
     Route::get('/letter-chief/edit/{id}', [LetterController::class, 'show']);
     Route::resource('/letter-chief', 'Chief\LetterController');

     Route::get('/verification', [VerificationStatusController::class, 'index']);

     Route::get('/verification/find', [VerificationStatusController::class, 'find']);

     Route::get('/verification/show/{id}', [VerificationStatusController::class, 'show']);

     Route::get('/download_pdf/{id}', [LetterController::class, 'print']);
     Route::get('/download_all/{id}', [LetterController::class, 'download_all']);
 }
);
