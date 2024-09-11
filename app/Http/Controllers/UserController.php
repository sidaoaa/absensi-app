<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Sesuaikan dengan model User Anda
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // Method ini seharusnya menampilkan halaman untuk menambahkan pengguna baru
        return view('admin.createuser');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'type' => 'required|in:1,2', // Pastikan type hanya 1 atau 2
        ]);

        // Simpan data pengguna baru ke dalam database
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password); // Enkripsi password menggunakan Hash
        $user->type = $request->type;
        $user->save();

        // Redirect ke halaman daftar pengguna dengan pesan sukses
        return redirect()->route('admin.summary')->with('success', 'Akun berhasil ditambahkan.');
    }

    public function edit($id)
    {
        // Ambil data pengguna berdasarkan $id untuk diedit
        $user = User::findOrFail($id);
        return view('admin.edituser', compact('user'));
    }
    

    public function update(Request $request, $id)
    {
        // Validasi input

        $user = User::findOrFail($id);

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'nullable|string|min:8',
            'type' => 'required|in:1,2',
        ];

        // Jika email tidak diubah, abaikan validasi unik
        if ($request->email === $user->email) {
            $rules['email'] = 'required|email|max:255'; // Tetap memeriksa format email
        } else {
            $rules['email'] = 'required|email|max:255|unique:users,email'; // Validasi unik hanya jika email diubah
        }

        $validatedData = $request->validate($rules);

        // Update data pengguna
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
    
        if (!empty($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }
    
        $user->type = $validatedData['type'];

        $user->save();

        // Redirect ke halaman ringkasan dengan pesan sukses
        return redirect()->route('admin.summary')->with('success', 'Akun berhasil diperbarui.');
    }
    

    public function destroy($id)
    {
        // Hapus data pengguna berdasarkan $id
        $user = User::findOrFail($id);
        $user->delete();

        // Redirect ke halaman ringkasan dengan pesan sukses
        return redirect()->route('admin.summary')->with('success', 'Akun berhasil dihapus.');
    }
}
