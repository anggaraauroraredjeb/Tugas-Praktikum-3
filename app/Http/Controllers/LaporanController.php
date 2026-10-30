<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class LaporanController extends Controller
{
    public function index(): View
    {
        $laporans = Laporan::latest()->paginate(10);

        return view('laporan.index', compact('laporans'));
    }

    public function create(): View
    {
        return view('laporan.create');
    }

    public function store(Request $request): View
    {
        $data = $request->validate([
            'nama_pelapor' => ['required', 'string', 'max:255'],
            'no_hp' => ['required', 'string', 'max:20'],
            'lokasi' => ['required', 'string', 'max:255'],
            'kecamatan' => ['required', 'string', 'max:120'],
            'tinggi_air' => ['required', 'integer', 'min:0', 'max:500'],
            'tanggal_kejadian' => ['required', 'date'],
            'keterangan' => ['nullable', 'string', 'max:2000'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        $data['tinggi_genangan'] = $data['tinggi_air'];
        $data['status'] = 'Menunggu';
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('laporan', 'public');
        }

        $laporan = Laporan::create($data);

        return view('laporan.show', compact('laporan'));
    }

    public function show(Laporan $laporan): View
    {
        return view('laporan.show', compact('laporan'));
    }

    public function edit(Laporan $laporan): View
    {
        return view('laporan.edit', compact('laporan'));
    }

    public function update(Request $request, Laporan $laporan): RedirectResponse
    {
        $data = $request->validate([
            'nama_pelapor' => ['required', 'string', 'max:255'],
            'no_hp' => ['required', 'string', 'max:20'],
            'lokasi' => ['required', 'string', 'max:255'],
            'kecamatan' => ['required', 'string', 'max:120'],
            'tinggi_air' => ['required', 'integer', 'min:0', 'max:500'],
            'tanggal_kejadian' => ['required', 'date'],
            'keterangan' => ['nullable', 'string', 'max:2000'],
            'status' => ['required', 'in:Menunggu,Diproses,Selesai'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        $data['tinggi_genangan'] = $data['tinggi_air'];
        $oldPhoto = $laporan->foto;
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('laporan', 'public');
        } else {
            unset($data['foto']);
        }

        $laporan->update($data);
        if ($oldPhoto && isset($data['foto'])) {
            Storage::disk('public')->delete($oldPhoto);
        }

        return redirect()
            ->route('laporans.show', $laporan)
            ->with('success', 'Laporan berhasil diperbarui.');
    }

    public function destroy(Laporan $laporan): RedirectResponse
    {
        $photo = $laporan->foto;
        $laporan->delete();
        if ($photo) {
            Storage::disk('public')->delete($photo);
        }

        return redirect()
            ->route('laporans.index')
            ->with('success', 'Laporan berhasil dihapus.');
    }
}
