<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;

Route::get('/', function () {
    return response()->json([
        'name' => config('app.name', 'Inclusive Profiling System'),
        'message' => 'Backend API is running.',
        'api_test' => url('/api/test'),
        'api_base' => url('/api/v1'),
    ]);
});

Route::get('/{any}', function () {
    if (! File::exists(public_path('build/manifest.json'))) {
        return redirect('/');
    }

    return view('app');
})->where('any', '.*');
