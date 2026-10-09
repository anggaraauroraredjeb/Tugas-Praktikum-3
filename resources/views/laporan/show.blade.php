@extends('layouts.app')

@section('title', 'Konfirmasi laporan')

@section('content')
    <section class="form-wrap">
        <div class="form-card confirmation-card">
            <x-alert type="success">Laporan berhasil dikirim.</x-alert>
            <p class="eyebrow">Konfirmasi laporan</p>
            <h1>Terima kasih, {{ $laporan->nama_pelapor }}</h1>
            <p class="intro">Data kejadian banjir sudah tercatat.</p>

            <dl class="report-details">
                <div><dt>Nama pelapor</dt><dd>{{ $laporan->nama_pelapor }}</dd></div>
                <div><dt>Lokasi kejadian</dt><dd>{{ $laporan->lokasi }}</dd></div>
                <div><dt>Tanggal kejadian</dt><dd>{{ $laporan->tanggal_kejadian->format('d-m-Y') }}</dd></div>
                <div><dt>Tinggi genangan</dt><dd>{{ $laporan->tinggi_genangan }} cm</dd></div>
                <div><dt>Waktu laporan</dt><dd>{{ $laporan->created_at->format('d-m-Y H:i') }}</dd></div>
            </dl>

            <a class="primary-button full-width" href="{{ route('laporans.index') }}">Lihat daftar laporan</a>
        </div>
    </section>
@endsection
