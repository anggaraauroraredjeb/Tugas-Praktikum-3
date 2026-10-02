@extends('layouts.app')

@section('title', 'Daftar laporan')

@section('content')
    <section class="page-heading">
        <div>
            <p class="eyebrow">Pemantauan kejadian</p>
            <h1>Daftar laporan banjir</h1>
            <p class="intro">Pantau laporan genangan yang masuk dari warga.</p>
        </div>
        <a class="primary-button" href="{{ route('laporans.create') }}">+ Buat laporan</a>
    </section>

    <section class="report-list" aria-label="Laporan banjir">
        <div class="list-summary">
            <h2>Laporan warga</h2>
            <span>{{ $laporans->count() }} laporan</span>
        </div>
        @forelse ($laporans as $laporan)
            @include('partials.report-card', ['laporan' => $laporan])
        @empty
            <div class="empty-state">
                <h3>Belum ada laporan</h3>
                <p>Laporan yang dikirim warga akan muncul di halaman ini.</p>
                <a class="text-link" href="{{ route('laporans.create') }}">Kirim laporan pertama <span aria-hidden="true">→</span></a>
            </div>
        @endforelse
    </section>
@endsection
