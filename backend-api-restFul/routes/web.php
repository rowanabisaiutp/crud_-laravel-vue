<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Exports\ProductosExport;
use Maatwebsite\Excel\Facades\Excel;

Route::get('productos/excel', function () {
    return Excel::download(new ProductosExport, 'productos.xlsx');
})->name('productos.excel');

Route::get('/productos/pdf', [ProductoController::class, 'downloadProductosPdf'])->name('productos.pdf');

Route::get('productos/json/{id}', [ProductoController::class, 'getProductoById']);
Route::get('productos/json', [ProductoController::class, 'getProductosJson']);
Route::resource('productos', ProductoController::class);
Route::resource('productos', ProductoController::class)->except(['show']);
Route::get('productos/create', [ProductoController::class, 'create'])->name('productos.create');


Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');
    Route::resource('productos', ProductoController::class)->except(['show']);
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [ProductoController::class, 'index'])->name('dashboard');
});

