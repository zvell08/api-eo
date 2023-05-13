<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function storeUser(Request $request)
    {
        $data = [
            'no_hp' => $request->no_hp,
            'nama' => $request->nama,
            'pin' => bcrypt($request->pin),
        ];

        try {
            $user = User::create($data);
            return response()->json($user);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Gagal Tambah User',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function checkOut(Request $request)
    {
        if ($user = User::firstWhere('pin', $request->pin)) {
            return response()->json($user);
        }

        return response()->json([
            'message' => 'pin salah',
        ], 401);
    }

    public function kurangiStok($id)
    {
        $barang = Tour::findOrFail($id);

        // Kurangi jumlah stok barang
        $barang->jumlah_tiket = $barang->jumlah_tiket - 1;
        // Simpan perubahan
        $barang->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Stok barang berhasil dikurangi.'
        ]);
    }

    public function pesan($id)
    {
        $pin = request()->input('pin');

        // Lakukan validasi PIN
        if ($pin != '1234') {
            return response()->json([
                'status' => 'error',
                'message' => 'PIN yang dimasukkan salah.'
            ]);
        }

        $barang = Tour::findOrFail($id);

        // Kurangi jumlah stok barang
        $barang->jumlah_tiket = $barang->jumlah_tiket - 1;

        // Simpan perubahan
        $barang->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Stok barang berhasil dikurangi.'
        ]);
    }


}