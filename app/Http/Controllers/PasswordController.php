<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

class PasswordController extends Controller
{
    public function show()
    {
        return view("password.show");
    }

    public function update(Request $request)
    {

        $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'confirmed', 'min:4', 'max:30'],
        ]);

        $user = $request->user();
        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => __('Wrong Password!')
            ]);
        }
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return Redirect::back()->with('success', __("Password has been updated!"));
    }
}
