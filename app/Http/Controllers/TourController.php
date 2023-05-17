<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TourController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function tour()
    {
        $tour = DB::table('tours')
            ->where('tipe', '=', 'T')
            ->select('id', 'name', 'tanggal', 'lokasi', 'jumlah_tiket', 'harga', 'description', 'even_schedule', 'year', 'country')
            ->get();

        return response()->json($tour);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function camp()
    {
        $camp = DB::table('tours')
            ->where('tipe', '=', 'C')
            ->select('id', 'name', 'tanggal', 'lokasi', 'jumlah_tiket', 'harga', 'description', 'even_schedule', 'year', 'country')
            ->get();

        return response()->json($camp);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function concert()
    {
        $concert = DB::table('tours')
            ->where('tipe', '=', 'K')
            ->select('id', 'name', 'tanggal', 'lokasi', 'jumlah_tiket', 'harga', 'description', 'even_schedule', 'year', 'country')
            ->get();

        return response()->json($concert);
    }

    /**
     * Display the specified resource.
     */
    public function semua()
    {
        $all = Tour::all();

        return response()->json($all);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tour $tour)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tour $tour)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tour $tour)
    {
        //
    }
}