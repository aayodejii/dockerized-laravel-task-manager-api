<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\TaskController;

Route::get('/', function () {
    return view('welcome');
});
