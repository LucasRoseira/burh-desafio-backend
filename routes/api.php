<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\UserController;

Route::get('users/search', [UserController::class, 'search']);
Route::apiResource('companies', CompanyController::class);
Route::apiResource('jobs', JobController::class);
Route::apiResource('users', UserController::class);