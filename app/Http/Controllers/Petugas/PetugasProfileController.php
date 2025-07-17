<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class PetugasProfileController extends Controller
{
     public function show(): View
    {
        return view('petugas.profile.show', [
            'user' => Auth::user(),
        ]);
    }

    public function edit(): View
    {
        return view('petugas.profile.edit', [
            'user' => Auth::user(),
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return Redirect::route('petugas.profile.show')->with('status', 'Profil berhasil diperbarui.');
    }
}