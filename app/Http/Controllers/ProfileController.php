<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        return view("profile.show", [
            'user' => $request->user()
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:100'],
            'username' => ['required', 'string', 'max:100', 'unique:users,email,' . $user->id],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'phone' => $request->phone,
        ]);
        return Redirect::back()->with('success', __("Profile information has been updated!"));
    }
}
