<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\frontend\PatientController;
use App\Http\Controllers\frontend\FrontendController;

/**
 * Frontend View Routes
 */

 Route::get('/', [FrontendController::class, 'ShowHomePage'])->name('show.home.page');
 Route::get('/login-page', [FrontendController::class, 'ShowloginPage'])->name('show.login.page');

 /**
  * Patient Routes
  */
 Route::get('/patient-register-page', [PatientController::class, 'ShowRegisterPage'])->name('patient.rag.page');
 Route::get('/patient-deshboard', [PatientController::class, 'ShowDeshbordPage'])->name('patient.desh.page');
 Route::get('/patient-profile', [PatientController::class, 'ShowProfilePage'])->name('patient.profile.page');
 Route::get('/change-password', [PatientController::class, 'ShowChangePassPage'])->name('patient.change.password-page');
 /**
  *  Patient Authentication
  */
 Route::post('/patient-register', [PatientController::class, 'Patient_Register'])->name('patient.register');
 Route::post('/patient-login', [PatientController::class, 'Patient_login'])->name('patient.login');