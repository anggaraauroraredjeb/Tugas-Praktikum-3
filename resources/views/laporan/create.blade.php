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
                    <label for="nama">Nama pelapor</label>
                    <input id="nama" type="text" name="nama" value="{{ old('nama') }}" maxlength="100" required>
                    @error('nama') <small class="field-error">{{ $message }}</small> @enderror
                </div>

                <div class="field-group">
                    <label for="lokasi">Lokasi kejadian (kecamatan/desa)</label>
                    <input id="lokasi" type="text" name="lokasi" value="{{ old('lokasi') }}" maxlength="150" required>
                    @error('lokasi') <small class="field-error">{{ $message }}</small> @enderror
                </div>

                <div class="field-group">
                    <label for="tinggi_genangan">Tinggi genangan air (cm)</label>
                    <input id="tinggi_genangan" type="number" name="tinggi_genangan" min="0" step="1" value="{{ old('tinggi_genangan') }}" required>
                    @error('tinggi_genangan') <small class="field-error">{{ $message }}</small> @enderror
                </div>

                <button class="primary-button full-width" type="submit">Kirim laporan</button>
            </form>
        </div>
    </section>
@endsection
