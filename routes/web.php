<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('root');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::resource('terms', App\Http\Controllers\TermController::class)->middleware(['auth']);

Route::resource('symptoms', App\Http\Controllers\SymptomController::class)->middleware(['auth']);

Route::resource('diseases', App\Http\Controllers\DiseaseController::class)->middleware(['auth']);

Route::resource('rules', App\Http\Controllers\RuleController::class)->middleware(['auth']);

Route::get('/search/disease/input', [App\Http\Controllers\SearchDeceaseController::class, 'input'])->name('searchInput');

Route::get('/search/disease/result', [App\Http\Controllers\SearchDeceaseController::class, 'result'])->name('searchResult');