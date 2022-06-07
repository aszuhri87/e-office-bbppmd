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
    // Route::post('/notification/dt', [NotificationController::class, 'dt']);
    // Route::get('/profile', [ProfileController::class, 'index']);
    // Route::post('/profile/update_password', [ProfileController::class, 'update_password']);
    // Route::post('/profile/update_profile', [ProfileController::class, 'update_profile']);
    // // Route::get('/sub-unit', [SubUnitController::class, 'index']);
    // Route::get('/list-applicant', [AdminController::class, 'list_applicant']);

    Route::post('/manage-user/dt', [UserManageController::class, 'dt']);
    // Route::post('/accepted/dt', [AcceptedController::class, 'dt']);
    // Route::post('/verification/dt', [VerificationController::class, 'dt']);
    // Route::get('/verification/download/{id}', [VerificationController::class, 'download']);
    // Route::post('/inbox/dt', [InboxController::class, 'dt']);
    // Route::post('/document-category/dt', [DocumentCategoryController::class, 'dt']);
    // Route::post('/sub-unit/dt', [SubUnitController::class, 'dt']);
    // Route::post('/unit/dt', [UnitController::class, 'dt']);
    // Route::post('/req-type/dt', [RequirementTypeController::class, 'dt']);
    // Route::post('/document-category-req/dt', [DocumentCategoryRequirementController::class, 'dt']);
    // Route::post('/document-req/dt', [DocumentRequirementController::class, 'dt']);

    // Route::resource('/notification', NotificationController::class);
    Route::resource('/manage-user', 'Admin\UserManageController');
    // Route::resource('/accepted', AcceptedController::class);
    // Route::resource('/verification', VerificationController::class);
    Route::get('/profile', [ProfileController::class, 'index']);
    // Route::resource('/document-category-req', DocumentCategoryRequirementController::class);
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

    // Route::resource('/sub-unit', SubUnitController::class);
    // Route::resource('/document-category', DocumentCategoryController::class);
    // Route::resource('/unit', UnitController::class);
    // Route::resource('/req-type', RequirementTypeController::class);

    // Route::post('/sub-unit', [SubUnitController::class, 'store']);
    // Route::get('/sub-unit/{id}', [SubUnitController::class, 'index']);
    // Route::put('/sub-unit/{id}', [SubUnitController::class, 'update']);

    // Route::put('/sub-unit/{id}', [SubUnitController::class, 'update']);
}
);
