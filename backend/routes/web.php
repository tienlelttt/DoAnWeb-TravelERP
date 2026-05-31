<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'message' => 'Digital Travel ERP API is running',
        'status' => 'OK'
    ]);
});
