<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/db-config', function () {
    $dbConfig = config('database.connections.mysql');
    dd($dbConfig);
});
