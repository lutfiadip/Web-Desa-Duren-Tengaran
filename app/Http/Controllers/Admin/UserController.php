<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VillageProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->get();
        $profile = VillageProfile::first() ?? new VillageProfile();
        return view('admin.users.index', compact('users', 'profile'));
    }

    public function create()
    {
        $profile = VillageProfile::first() ?? new VillageProfile();
        return view('admin.users.create', compact('profile'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar oleh pengguna lain.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal harus 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Akun admin baru berhasil dibuat.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $profile = VillageProfile::first() ?? new VillageProfile();
        return view('admin.users.edit', compact('user', 'profile'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        $request->validate($rules, [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar oleh pengguna lain.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal harus 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Akun admin berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Prevent self-deletion
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif login.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Akun admin berhasil dihapus.');
    }
}
