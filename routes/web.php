<?php

use Illuminate\Support\Facades\Route;

// Dummy login route untuk mencegah RouteNotFoundException dari Sanctum
Route::get('/login', function () {
    return response()->json(['message' => 'Please login via API'], 401);
})->name('login');

Route::get('/', function () {
    return response()->json(['message' => 'SIKAMU API']);
});
