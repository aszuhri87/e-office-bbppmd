<?php

use App\Http\Controllers\ChiefSubDiv\DashboardController;
use App\Http\Controllers\ChiefSubDiv\LetterController;

Route::group(['prefix' => 'chief_sub_div', 'middleware' => ['role:chief_of_sub_division']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::post('/letter-chief_sub_div/dt', [LetterController::class, 'dt']);
    Route::put('/letter-chief_sub_div/edit/{id}', [LetterController::class, 'update']);
    Route::get('/letter-chief_sub_div/edit/{id}', [LetterController::class, 'show']);
    Route::resource('/letter-chief_sub_div', 'ChiefSubDiv\LetterController');
}
);
