<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\JobController;

Route::apiResource('companies', CompanyController::class);
Route::apiResource('jobs', JobController::class);