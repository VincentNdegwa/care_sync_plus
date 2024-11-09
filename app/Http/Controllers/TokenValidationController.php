<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TokenValidationController extends Controller
{
    public function checkIfValid(Request $request)
    {
        if (Auth::check()) {
            return response()->json([
                "error" => false,
                'message' => 'Token validation successful',
                "user" => Auth::user()
            ], 200);
        } else {
            return response()->json([
                "error" => true,
                'message' => 'Token validation failed',
            ], 401);
        }
    }
}
