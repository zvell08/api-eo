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

    public function pesanBarang(Request $request, $id)
    {
        $barang = Tour::findOrFail($id);

        // Validasi PIN
        $user = User::where('pin', $request->input('pin'))->first();
        if ($user) {
            // Kurangi stok barang sebanyak 1
            $barang->jumlah_tiket -= 1;
            $barang->save();

            return response()->json([
                'message' => 'Pembelian berhasil dilakukan'
            ], 201);
        } else {
            return response()->json([
                'message' => 'PIN yang dimasukkan salah'
            ], 401);
        }
    }

    public function store(Request $request)
    {
        // Validasi inputan
        $validatedData = $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        // Dapatkan data barang dari database
        $barang = Tour::findOrFail($validatedData['barang_id']);

        // Kurangi jumlah stok barang
        $stokBarang = $barang->stokBarang;
        $stokBarang->jumlah -= 1; // kurangi 1
        $stokBarang->save();


        // Tampilkan pesan sukses
        return response()->json(['message' => 'Transaksi berhasil disimpan']);
    }

}