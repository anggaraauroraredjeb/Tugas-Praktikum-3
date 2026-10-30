@extends('layouts.app')

@section('title', 'Konfirmasi laporan')

@section('content')
    <section class="form-wrap">
        <div class="form-card confirmation-card">
            @if (session('success'))
                <x-alert type="success">{{ session('success') }}</x-alert>
            @elseif (!auth()->check())
                <x-alert type="success">Laporan berhasil dikirim.</x-alert>
            @endif
            <p class="eyebrow">Konfirmasi laporan</p>
            <h1>Terima kasih, {{ $laporan->nama_pelapor }}</h1>
            <p class="intro">Data kejadian banjir sudah tercatat.</p>

            <dl class="report-details">
                <div><dt>Nama pelapor</dt><dd>{{ $laporan->nama_pelapor }}</dd></div>
                <div><dt>Nomor HP</dt><dd>{{ $laporan->no_hp ?: 'Tidak dicantumkan' }}</dd></div>
                <div><dt>Kecamatan</dt><dd>{{ $laporan->kecamatan ?: 'Tidak dicantumkan' }}</dd></div>
                <div><dt>Lokasi kejadian</dt><dd>{{ $laporan->lokasi }}</dd></div>
                <div><dt>Tanggal kejadian</dt><dd>{{ $laporan->tanggal_kejadian->format('d-m-Y') }}</dd></div>
                <div><dt>Tinggi genangan</dt><dd>{{ $laporan->tinggi_air ?? $laporan->tinggi_genangan }} cm</dd></div>
                <div><dt>Keterangan</dt><dd>{{ $laporan->keterangan ?: 'Tidak ada keterangan' }}</dd></div>
                <div><dt>Status penanganan</dt><dd>{{ $laporan->status }}</dd></div>
                <div><dt>Waktu laporan</dt><dd>{{ $laporan->created_at->format('d-m-Y H:i') }}</dd></div>
            </dl>

            @if ($laporan->foto)
                <a class="report-photo-link" href="{{ asset('storage/'.$laporan->foto) }}" target="_blank" rel="noopener">
                    <img class="report-photo" src="{{ asset('storage/'.$laporan->foto) }}" alt="Foto bukti banjir di {{ $laporan->lokasi }}">
                    <span>Lihat foto bukti ukuran penuh</span>
                </a>
            @endif

            @auth
                <div class="report-actions">
                    <a class="primary-button" href="{{ route('laporans.edit', $laporan) }}">Edit laporan</a>
                    <form action="{{ route('laporans.destroy', $laporan) }}" method="post" onsubmit="return confirm('Hapus laporan ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="danger-button" type="submit">Hapus laporan</button>
                    </form>
                </div>
            @endauth

            @auth
                <a class="primary-button full-width" href="{{ route('laporans.index') }}">Lihat daftar laporan</a>
            @else
                <a class="primary-button full-width" href="{{ route('laporans.create') }}">Kirim laporan lain</a>
            @endauth
        </div>
    </section>
@endsection
