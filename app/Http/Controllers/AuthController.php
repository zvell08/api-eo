<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        if ($user = User::firstWhere('no_hp', $request->no_hp)) {
            return response()->json($user);
        }

        return response()->json([
            'message' => 'No HP tidak ditemukan',
        ], 401);
    }
}