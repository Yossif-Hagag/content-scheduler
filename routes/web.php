<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});
Route::post('/logout', function (Request $request) {
    Auth::guard('web')->logout(); 
    $request->session()->invalidate(); 
    $request->session()->regenerateToken(); 

    return redirect('/'); 
})->name('logout');