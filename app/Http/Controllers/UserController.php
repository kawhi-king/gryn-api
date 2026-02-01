<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller {

    public function userIndex()
    {
        $test = User::where('name', 'teddy')->first();

        if (!$test) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json($test);
    }
}