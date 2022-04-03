<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadosController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/empleado/get', [EmpleadosController::class, 'getempleados'])->name('getempleados');
