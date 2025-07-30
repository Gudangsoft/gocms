<?php

use Illuminate\Support\Facades\Route;

// Test paling sederhana
Route::get('/', function () {
    return 'HOMEPAGE BEKERJA!';
});

Route::get('/test', function () {
    return 'TEST BEKERJA!';
});
