<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DoneController;
use App\Http\Controllers\Admin\InputLetterController;
use App\Http\Controllers\Admin\LetterController;
use App\Http\Controllers\Admin\PositionController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\UserManageController;
use App\Http\Controllers\Admin\VerificationStatusController;
use App\Http\Controllers\Admin\WishController;

Route::group(['prefix' => 'admin', 'middleware' => ['role:admin|superadmin']], function () {
    Route::get('/verification', [VerificationStatusController::class, 'index']);
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::post('/manage-user/dt', [UserManageController::class, 'dt']);
    Route::resource('/manage-user', 'Admin\UserManageController');

    Route::get('/profile', [ProfileController::class, 'index']);
    Route::post('/letter/dt', [LetterController::class, 'dt']);
    Route::put('/letter/edit/{id}', [LetterController::class, 'update']);
    Route::get('/letter/edit/{id}', [LetterController::class, 'show']);
    Route::resource('/letter', 'Admin\LetterController');

    Route::post('/unit/dt', [UnitController::class, 'dt']);
    Route::resource('/unit', 'Admin\UnitController');

    Route::post('/wish/dt', [WishController::class, 'dt']);
    Route::resource('/wish', 'Admin\WishController');

    Route::post('/position/dt', [PositionController::class, 'dt']);
    Route::resource('/position', 'Admin\PositionController');

    Route::get('/verification/find', [VerificationStatusController::class, 'find']);

    Route::get('/verification/show/{id}', [VerificationStatusController::class, 'show']);

    Route::post('/done/dt', [DoneController::class, 'dt']);
    Route::put('/done/edit/{id}', [DoneController::class, 'update']);
    Route::get('/done/edit/{id}', [DoneController::class, 'show']);
    Route::resource('/done', 'Admin\DoneController');

    Route::post('/input-letter', [LetterController::class, 'store']);
    Route::get('/input-letter', [InputLetterController::class, 'index']);
}
);
