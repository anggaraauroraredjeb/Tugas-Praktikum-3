@extends('layouts.app')

@section('title', 'Konfirmasi Laporan')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endpush

@section('content')
    <section class="legacy-page">
        <div class="result-card">
            <p class="eyebrow">Laporan Banjir</p>
            <h1>Laporan berhasil dikirim</h1>
            <p class="intro">Berikut data laporan yang telah Anda masukkan.</p>

            <dl class="report-details">
                <div>
                    <dt>Nama pelapor</dt>
                    <dd>{{ $nama }}</dd>
                </div>
                <div>
                    <dt>Lokasi kejadian</dt>
                    <dd>{{ $lokasi }}</dd>
                </div>
                <div>
                    <dt>Tinggi genangan</dt>
                    <dd>{{ $tinggi_genangan }} cm</dd>
                </div>
            </dl>

            <a class="secondary-button" href="{{ url('/form') }}">Buat laporan baru</a>
        </div>
    </section>
@endsection