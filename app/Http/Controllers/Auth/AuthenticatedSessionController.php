<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;
use PhpParser\Node\Stmt\Catch_;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {


        try {
            $request->validate([
                'email' => 'required|email|exists:users,email',
                'password' => 'required',
            ]);
            $user = User::where('email', $request->email)->first();
            if (!$user || !Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }
            $token = $user->createToken('API Token')->plainTextToken;
            return response()->json([
                "error" => false,
                'message' => 'Login successful',
                'token' => $token,
                'user' => $user
            ], 200);
        } catch (ValidationException $th) {
            return response()->json([
                "error" => true,
                "message" => $th->getMessage(),
                'errors' => $th->errors()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "error" => true,
                'message' => 'An error occurred during login',
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {

        try {
            $token = $request->bearerToken();

            $tokenId = explode('|', $token)[0];
            $request->user()->tokens()->where('id', $tokenId)->delete();
            return response()->json([
                "error" => false,
                'message' => 'Logout successful'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "error" => true,
                'message' => 'An error occurred during logout',
                'errors' => $th->getMessage()
            ], 500);
        }
    }
}
