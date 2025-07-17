<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Bidang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $users = User::orderBy('name')->paginate($perPage)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $bidangs = Bidang::all();
        return view('admin.users.create', compact('bidangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:100',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|confirmed|min:6',
            'role'       => 'required|in:admin,petugas',
            'bidang_id'  => $request->role === 'petugas' ? 'required|exists:bidangs,id' : '',
            'photo'      => 'nullable|image|max:2048',
        ]);

        $photoName = null;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $photoName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('gambar'), $photoName);
        }

        User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'role'       => $request->role,
            'bidang_id'  => $request->role === 'petugas' ? $request->bidang_id : null,
            'photo'      => $photoName,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $bidangs = Bidang::all();
        return view('admin.users.edit', compact('user', 'bidangs'));
    }

   public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'password' => 'nullable|min:6',
        'role' => 'required|in:admin,petugas',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $user->name = $request->name;
    $user->email = $request->email;
    $user->role = $request->role;

    if ($request->filled('password')) {
        $user->password = bcrypt($request->password);
    }

    if ($request->hasFile('photo')) {
        // Hapus foto lama
        if ($user->photo && \Storage::exists('public/profile/' . $user->photo)) {
            \Storage::delete('public/profile/' . $user->photo);
        }

        // Simpan foto baru
        $photoName = time() . '.' . $request->photo->extension();
        $request->photo->storeAs('public/profile', $photoName);
        $user->photo = $photoName;
    }

    $user->save();

    return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui.');
}


    public function destroy(User $user)
    {
        if ($user->photo && file_exists(public_path('gambar/' . $user->photo))) {
            unlink(public_path('gambar/' . $user->photo));
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }
}
