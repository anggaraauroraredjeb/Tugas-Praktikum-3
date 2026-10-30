@extends('layouts.app')

@section('title', 'Edit laporan')

@section('content')
    <section class="form-wrap">
        <div class="page-heading compact-heading">
            <div>
                <p class="eyebrow">Pengelolaan laporan</p>
                <h1>Edit laporan</h1>
                <p class="intro">Perbarui informasi kejadian dan status penanganan.</p>
            </div>
        </div>

        <div class="form-card">
            @if ($errors->any())
                <x-alert type="error">Mohon periksa kembali data yang Anda isi.</x-alert>
            @endif
            @include('laporan._form', ['laporan' => $laporan])
        </div>
    </section>
@endsection