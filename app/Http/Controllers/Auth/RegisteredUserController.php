<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {

        // return response()->json($request->all());

        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $token = $user->createToken('API Token')->plainTextToken;

            return response()->json([
                "error" => false,
                'message' => 'Registration successful',
                'token' => $token,
                "user" => $user
            ], 200);
        } catch (ValidationException $th) {
            return response()->json([
                "error" => true,
                'message' => 'Invalid details provided',
                'errors' => $th->errors()
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "error" => true,
                'message' => 'An error occurred during registration',
                'errors' => $th->getMessage()
            ], 500);
        }
    }
}
