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

            <form action="{{ route('laporans.store') }}" method="post">
                @csrf
                <div class="field-group">
                    <label for="nama_pelapor">Nama pelapor</label>
                    <input id="nama_pelapor" type="text" name="nama_pelapor" value="{{ old('nama_pelapor') }}" maxlength="255" required>
                    @error('nama_pelapor') <small class="field-error">{{ $message }}</small> @enderror
                </div>

                <div class="field-group">
                    <label for="lokasi">Lokasi kejadian (kecamatan/desa)</label>
                    <input id="lokasi" type="text" name="lokasi" value="{{ old('lokasi') }}" maxlength="255" required>
                    @error('lokasi') <small class="field-error">{{ $message }}</small> @enderror
                </div>

                <div class="field-group">
                    <label for="tanggal_kejadian">Tanggal kejadian</label>
                    <input id="tanggal_kejadian" type="date" name="tanggal_kejadian" value="{{ old('tanggal_kejadian', now()->toDateString()) }}" required>
                    @error('tanggal_kejadian') <small class="field-error">{{ $message }}</small> @enderror
                </div>

                <div class="field-group">
                    <label for="tinggi_genangan">Tinggi genangan air (cm)</label>
                    <input id="tinggi_genangan" type="number" name="tinggi_genangan" min="10" max="150" step="1" value="{{ old('tinggi_genangan') }}" required>
                    @error('tinggi_genangan') <small class="field-error">{{ $message }}</small> @enderror
                </div>

                <button class="primary-button full-width" type="submit">Kirim laporan</button>
            </form>
        </div>
    </section>
@endsection
