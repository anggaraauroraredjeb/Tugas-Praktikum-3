<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $laporans = Laporan::all();

        return view('laporan.index', compact('laporans'));
    }

    public function create()
    {
        return view('laporan.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_pelapor' => ['required', 'string', 'max:255'],
            'lokasi' => ['required', 'string', 'max:255'],
            'tinggi_genangan' => ['required', 'integer', 'min:10', 'max:150'],
            'tanggal_kejadian' => ['required', 'date'],
        ]);

        $laporan = Laporan::create($data);

        return view('laporan.show', compact('laporan'));
    }

    public function show(int $id)
    {
        $laporan = Laporan::findOrFail($id);

        return view('laporan.show', compact('laporan'));
    }
}
