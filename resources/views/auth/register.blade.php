@extends('layouts.app')

@section('title', 'Register petugas')

@section('content')
    <section class="form-wrap">
        <div class="page-heading compact-heading">
            <div>
                <p class="eyebrow">Akun petugas</p>
                <h1>Register</h1>
                <p class="intro">Buat akun untuk mengakses pengelolaan laporan.</p>
            </div>
        </div>

        <div class="form-card">
            @if ($errors->any())
                <x-alert type="error">Mohon periksa kembali data yang Anda isi.</x-alert>
            @endif

            <form action="{{ route('register.store') }}" method="post">
                @csrf
                <div class="field-group">
                    <label for="name">Nama</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" maxlength="255" autocomplete="name" required>
                    @error('name') <small class="field-error">{{ $message }}</small> @enderror
                </div>

                <div class="field-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" maxlength="255" autocomplete="email" required>
                    @error('email') <small class="field-error">{{ $message }}</small> @enderror
                </div>

                <div class="field-group">
                    <label for="password">Password (minimal 8 karakter)</label>
                    <input id="password" type="password" name="password" autocomplete="new-password" required>
                    @error('password') <small class="field-error">{{ $message }}</small> @enderror
                </div>

                <div class="field-group">
                    <label for="password_confirmation">Konfirmasi password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password" required>
                </div>

                <button class="primary-button full-width" type="submit">Buat akun</button>
            </form>
        </div>
    </section>
@endsection