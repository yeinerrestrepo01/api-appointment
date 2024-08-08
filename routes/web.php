<?php

use App\Http\Controllers\api\AppointMentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::apiResource('api/appointMent', AppointMentController::class);
