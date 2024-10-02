<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\SavedController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('posts', PostController::class);
Route::apiResource('users', UserController::class);
Route::apiResource('saved', SavedController::class);