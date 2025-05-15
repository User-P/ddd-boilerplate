<?php

use Illuminate\Support\Facades\Route;
use Src\admin\user\infrastructure\controllers\CreateUserPOSTController;
use Src\admin\user\infrastructure\controllers\GetUserByIdGETController;

Route::get('/{id}', [GetUserByIdGETController::class, 'index'])
    ->name('user.getById')
    ->where('id', '[0-9]+');

Route::post('/store', [CreateUserPOSTController::class, 'index'])
    ->name('user.store');
