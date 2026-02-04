<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Illuminate\Validation\ValidationException;

Route::get('/test', UserController::class . '@userIndex')->middleware('auth:sanctum');

Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ["L'email ou le mot de passe est incorrect."],
        ]);
    }

    return $user->createToken($request->email)->toJson();
});

Route::post('/forgot-password', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
    ]); 

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ["L'email ou le mot de passe est incorrect."],
        ]);
    }

    // return $user->createToken($request->email)->toJson();
    // TODO: send email
});
