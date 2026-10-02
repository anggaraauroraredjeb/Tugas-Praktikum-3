@extends('layouts.app')

@section('title', 'Konfirmasi laporan')

@section('content')
    <section class="form-wrap">
        <div class="form-card confirmation-card">
            <x-alert type="success">Laporan berhasil dikirim.</x-alert>
            <p class="eyebrow">Konfirmasi laporan</p>
            <h1>Terima kasih, {{ $laporan['nama'] }}</h1>
            <p class="intro">Data kejadian banjir sudah tercatat.</p>

            <dl class="report-details">
                <div><dt>Nama pelapor</dt><dd>{{ $laporan['nama'] }}</dd></div>
                <div><dt>Lokasi kejadian</dt><dd>{{ $laporan['lokasi'] }}</dd></div>
                <div><dt>Tinggi genangan</dt><dd>{{ $laporan['tinggi_genangan'] }} cm</dd></div>
                <div><dt>Waktu laporan</dt><dd>{{ date('d-m-Y H:i', strtotime($laporan['created_at'])) }}</dd></div>
            </dl>

            <a class="primary-button full-width" href="{{ route('laporans.index') }}">Lihat daftar laporan</a>
        </div>
    </section>
@endsection
