<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SiswaController;
use App\Http\Controllers\Api\GuruController;
use App\Http\Controllers\Api\AbsensiController;
use App\Http\Controllers\Api\NilaiController;
use App\Http\Controllers\Api\NotifikasiController;

use App\Http\Controllers\Api\ProfileController;

use App\Http\Controllers\Api\ImportController;

// Auth (public)
Route::post('/login',    [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/profile',  [ProfileController::class, 'show']);
    Route::put('/profile',  [ProfileController::class, 'update']);

    Route::apiResource('siswa', SiswaController::class);
    Route::post('siswa/import', [ImportController::class, 'importSiswa']);
    Route::apiResource('guru', GuruController::class);
    Route::post('guru/import', [ImportController::class, 'importGuru']);
    Route::post('guru/{id}/reset-password', [GuruController::class, 'resetPassword']);
    Route::apiResource('absensi',     AbsensiController::class);
    Route::apiResource('nilai',       NilaiController::class);
    Route::apiResource('notifikasi',  NotifikasiController::class);
});
