<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // Validasi data yang diterima
        $validator = Validator::make($request->all(), [
            'name_customer' => 'required|string|max:255',
            'no_hp' => 'required|string|max:25',
            'alamat' => 'required|string|max:255',
            'jenisLayanan' => 'required|string|max:255',
            'berat' => 'required|string|max:255',
            'tgl_terima' => 'required|date',
            'tgl_selesai' => 'required|date',
            'catatan' => 'required|string|max:255'
        ]);

        // Jika validasi gagal, kembalikan pesan kesalahan
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 422);
        }

        // Buat dan simpan order baru
        $order = Order::create([
            'name_customer' => $request->name_customer,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'jenisLayanan' => $request->jenisLayanan,
            'berat' => $request->berat,
            'tgl_terima' => $request->tgl_terima,
            'tgl_selesai' => $request->tgl_selesai,
            'catatan' => $request->catatan,
        ]);

        // Beri respons ke client bahwa registrasi berhasil
        return response()->json([
            'message' => 'Order berhasil',
            'order' => $order
        ], 201);
    }
}
