<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => Rule::unique("users", "email")->ignore($request->user()->id),
            ]);

            $user = $request->user();
            $user->name = $validatedData['name'];
            $user->email = $validatedData['email'];
            $user->save();

            return response()->json([
                "error" => false,
                'message' => 'Profile updated successfully.',
                'user' => $user
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
                'errors' => $e->errors()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred while updating your profile.',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function getUserProfile(Request $request)
    {
        $user = $request->user();
        return response()->json([
            "error" => false,
            "user" => $user
        ]);
    }
}
