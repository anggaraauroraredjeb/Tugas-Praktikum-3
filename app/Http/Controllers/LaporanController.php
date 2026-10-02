<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $laporans = collect(session('laporan_banjir', []))
            ->sortByDesc('created_at')
            ->values();

        return view('laporan.index', compact('laporans'));
    }

    public function create()
    {
        return view('laporan.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'lokasi' => ['required', 'string', 'max:150'],
            'tinggi_genangan' => ['required', 'integer', 'min:0'],
        ]);

        $laporans = session('laporan_banjir', []);
        $id = (int) session('laporan_banjir_next_id', 1);
        $laporans[$id] = $data + [
            'id' => $id,
            'created_at' => now()->toDateTimeString(),
        ];

        session([
            'laporan_banjir' => $laporans,
            'laporan_banjir_next_id' => $id + 1,
        ]);

        return redirect()->route('laporans.show', $id);
    }

    public function show(int $id)
    {
        $laporan = session('laporan_banjir', [])[$id] ?? null;
        abort_if($laporan === null, 404);

        return view('laporan.show', compact('laporan'));
    }
}
