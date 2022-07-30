<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\frontend\PatientController;
use App\Http\Controllers\frontend\FrontendController;

/**
 * Frontend View Routes
 */

 Route::get('/', [FrontendController::class, 'ShowHomePage'])->name('show.home.page');
 Route::get('/login-page', [FrontendController::class, 'ShowloginPage'])->name('show.login.page')->middleware('admin.rediract');

 /**
  * Patient Routes
  */
 Route::get('/patient-register-page', [PatientController::class, 'ShowRegisterPage'])->name('patient.rag.page')->middleware('admin.rediract');
 Route::get('/patient-deshboard', [PatientController::class, 'ShowDeshbordPage'])->name('patient.desh.page')->middleware('admin');
 Route::get('/patient-profile', [PatientController::class, 'ShowProfilePage'])->name('patient.profile.page')->middleware('admin');
 Route::get('/change-password', [PatientController::class, 'ShowChangePassPage'])->name('patient.change.password-page')->middleware('admin');
 Route::post('/change-password', [PatientController::class, 'password_change'])->name('patient.change.password');
 Route::get('/patient_access_account/{token?}', [PatientController::class, 'Account_Active_Token'])->name('account.active.token');
 /**
  *  Patient Authentication
  */
 Route::post('/patient-register', [PatientController::class, 'Patient_Register'])->name('patient.register');
 Route::post('/patient-login', [PatientController::class, 'Patient_login'])->name('patient.login');
 Route::get('/patient-logout', [PatientController::class, 'Patient_logout'])->name('patient.logout');
 /**
  * Patient Forget password
  */
  Route::get('/patient-forget-password', [PatientController::class,'Patient_Forget_password_page'])->name('patient.forget.password.page')->middleware('admin.rediract');
  Route::post('/patient-password-reset', [PatientController::class,'Patient_password_resting'])->name('patient.password.reset');
  Route::get('/patient-access-reset/{email}/{token}', [PatientController::class,'ShowResetPassword'])->name('patient.access.reset');
  Route::post('/reset-password', [PatientController::class,'ResetPassword'])->name('reset.password');