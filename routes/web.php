<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadosController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/empleado/get', [EmpleadosController::class, 'getempleados'])->name('getempleados');
Route::post('/empleado/add', [EmpleadosController::class, 'store'])->name('store');
Route::post('/empleado/update', [EmpleadosController::class, 'updatefn'])->name('updatefn');
Route::delete('/empleado/delete/{id}', [EmpleadosController::class, 'destroy'])->name('destroy');
Route::post('/empleado/active', [EmpleadosController::class, 'statuschange'])->name('statuschange');
