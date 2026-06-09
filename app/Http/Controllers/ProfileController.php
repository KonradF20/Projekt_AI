<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePasswordRequest;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile');
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $request->user()->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Hasło zostało pomyślnie zmienione!');
    }
}
