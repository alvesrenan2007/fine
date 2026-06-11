<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\MarketplacesController;
use App\Http\Controllers\ReportsController;

Route::get('/', [ProductsController::class, 'index'])->name('homepage');

Route::get('/products', [ProductsController::class, 'index'])->name('products.index');
Route::get('/products/create', [ProductsController::class, 'create'])->name('products.create');
Route::get('/product/edit/{id}', [ProductsController::class, 'edit'])->name('products.edit');
Route::post('/products/store', [ProductsController::class, 'store'])->name('products.store');
Route::post('/product/update/{id}', [ProductsController::class, 'update'])->name('products.update');
Route::delete('/products/delete/{id}', [ProductsController::class, 'delete'])->name('products.delete');

Route::get('/categories/create', [categoriesController::class, 'create'])->name('categories.create');

Route::get('/companies', [CompaniesController::class, 'index'])->name('companies.index');

Route::get('/marketplaces', [MarketplacesController::class, 'index'])->name('marketplaces.index');

Route::get('/reports', [ReportsController::class, 'index'])->name('reports.index');
Route::get('/report/by-product', [ReportsController::class, 'byProduct'])->name('reports.byProduct');
