<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class UserCT extends Controller
{
    public function store(Request $request)
    {
        // Validasi data yang diterima
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'no_hp' => 'required|string|max:50',
            'password' => 'required|string|max:255',

        ]);

        // Jika validasi gagal, kembalikan pesan kesalahan
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 422);
        }

        // Buat dan simpan user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'password' => Hash::make($request->password),
        ]);

        // Beri respons ke client bahwa registrasi berhasil
        return response()->json([
            'message' => 'Registrasi berhasil',
            'user' => $user
        ], 201);
    }
}