<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DataController extends Controller
{
    public function form() {
        return view('form');
    }

    public function proses(Request $request) {
        $nama = $request->input('nama');
        $lokasi = $request->input('lokasi');
        $tinggi_genangan = $request->input('tinggi_genangan');

        return view('hasil', compact('nama', 'lokasi', 'tinggi_genangan'));
    }
}
