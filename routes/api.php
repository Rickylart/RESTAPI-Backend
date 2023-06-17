<?php

use App\Http\Controllers\SevezMedicalBackend\MedicalController;
use App\Http\Controllers\SevezMedicalBackend\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

 //*****User Register & Login */
Route::post('/register', [UserController::class, 'registerUser'])->name('register');
Route::post('/login', [UserController::class, 'login'])->name('login');

Route::group(['middleware' => ['auth:sanctum']], function () {
    //*****User Actions */
    Route::get('/get_patient_medical_reports', [ MedicalController::class, 'getPatientMedicalReport'])->name('medical_reports');
    Route::post('/store_medical_report', [ MedicalController::class, 'storeMedicalReport'])->name('store_medical_report');
    Route::delete('/delete_medical_report/{id}', [ MedicalController::class, 'deleteMedicalReport'])->name('delete_medical_report');

    //*****GraphQl Actions */
    Route::post('/store_medical_report', [ MedicalController::class, 'storeGraphQLMedicalReport'])->name('store_graphql_medical_report');
});

Route::fallback(function(){
    return response()->json([
        'message' => 'Page Not Found or Invalid token'], 422);
});
