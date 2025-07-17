<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;


class AdminProfileController extends Controller
{
    public function show(): View
    {
        return view('admin.profile.show', [
            'user' => Auth::user()
        ]);
    }

    public function edit(): View
    {
        return view('admin.profile.edit', [
            'user' => Auth::user()
        ]);
    }

    public function update(Request $request)
{
   $user = Auth::user();


    $validated = $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:users,email,' . $user->id,
        'username' => 'nullable|string|max:255',
        'phone'    => 'nullable|string|max:20',
        'address'  => 'nullable|string|max:255',
        'photo'    => 'nullable|image|max:2048',
        'password' => 'nullable|string|min:8',
    ]);

    // Update password hanya jika diisi
    if ($request->filled('password')) {
        $validated['password'] = bcrypt($request->password);
    } else {
        unset($validated['password']);
    }

    // Upload foto jika ada
    if ($request->hasFile('photo')) {
        if ($user->photo) {
            Storage::delete('public/profile/' . $user->photo);
        }
        $validated['photo'] = $request->file('photo')->store('profile', 'public');
        $validated['photo'] = basename($validated['photo']);
    }

    $user->update($validated);

    return redirect()->route('admin.profile.show')->with('success', 'Profil berhasil diperbarui!');
}

}
