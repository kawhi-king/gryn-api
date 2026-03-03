<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CalculationController;
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

Route::middleware('auth:sanctum')->group(function () {
    // Info utilisateur
    Route::get('/user', function (Request $request) {
        return response()->json([
            'success' => true,
            'data' => $request->user()
        ]);
    });

    // Routes calculs
    Route::prefix('calculations')->group(function () {
        Route::post('/', [CalculationController::class, 'store']);
        Route::get('/', [CalculationController::class, 'index']);
        Route::get('/latest', [CalculationController::class, 'latest']);
        Route::delete('/{id}', [CalculationController::class, 'destroy']);
    });
});