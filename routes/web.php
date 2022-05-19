<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\UpazilaController;
use App\Http\Controllers\UnionController;

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

// Home Page
Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');
Route::post('/get-district', [DashboardController::class, 'get_district'])->name('get_district');
Route::post('/get-upazila', [DashboardController::class, 'get_upazila'])->name('get_upazila');
Route::post('/get-union', [DashboardController::class, 'get_union'])->name('get_union');
Route::post('/get-population', [DashboardController::class, 'get_population'])->name('get_population');

// Division
Route::get('/division', [DivisionController::class, 'division'])->name('division');
Route::post('/division-process', [DivisionController::class, 'division_process'])->name('division_process');
Route::get('/get-Divisions', [DivisionController::class, 'getDivisions'])->name('getDivisions');
Route::post('/edit-division', [DivisionController::class, 'edit_division'])->name('edit_division');


// District
Route::get('/district', [DistrictController::class, 'district'])->name('district');
Route::get('/get-district', [DistrictController::class, 'getDistrict'])->name('getDistrict');
Route::post('/district-process', [DistrictController::class, 'district_process'])->name('district_process');
Route::post('/edit-district', [DistrictController::class, 'edit_district'])->name('edit_district');


// upazila
Route::get('/upazila', [UpazilaController::class, 'upazila'])->name('upazila');
Route::get('/get-upazila', [UpazilaController::class, 'getUpazila'])->name('getUpazila');
Route::post('/district-find', [UpazilaController::class, 'district_find'])->name('district_find');
Route::post('/upazila-process', [UpazilaController::class, 'upazila_process'])->name('upazila_process');
Route::post('/edit-upazila', [UpazilaController::class, 'edit_upazila'])->name('edit_upazila');


// union
Route::get('/union', [UnionController::class, 'union'])->name('union');
Route::post('/upazila-find', [UnionController::class, 'upazila_find'])->name('upazila_find');
Route::get('/get-union', [UnionController::class, 'getUnion'])->name('getUnion');
Route::post('/union-process', [UnionController::class, 'union_process'])->name('union_process');
Route::post('/edit-union', [UnionController::class, 'edit_union'])->name('edit_union');
