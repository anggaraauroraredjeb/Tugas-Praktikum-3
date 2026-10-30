@extends('layouts.app')

@section('title', 'Buat laporan')

@section('content')
    <section class="form-wrap">
        <div class="page-heading compact-heading">
            <div>
                <p class="eyebrow">BPBD Kabupaten Bandung</p>
                <h1>Laporan banjir</h1>
                <p class="intro">Silakan isi data kejadian banjir dengan lengkap.</p>
            </div>
        </div>

        <div class="form-card">
            @if ($errors->any())
                <x-alert type="error">Mohon periksa kembali data yang Anda isi.</x-alert>
            @endif
            @include('laporan._form', ['laporan' => null])
        </div>
    </section>
@endsection
