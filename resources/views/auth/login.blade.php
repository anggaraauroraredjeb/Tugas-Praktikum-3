@extends('layouts.app')

@section('title', 'Login petugas')

@section('content')
    <section class="form-wrap">
        <div class="page-heading compact-heading">
            <div>
                <p class="eyebrow">Akses petugas</p>
                <h1>Login</h1>
                <p class="intro">Masuk untuk melihat daftar laporan warga.</p>
            </div>
        </div>

        <div class="form-card">
            @if ($errors->any())
                <x-alert type="error">Email atau password tidak valid.</x-alert>
            @endif

            <form action="{{ route('login.store') }}" method="post">
                @csrf
                <div class="field-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="username" required autofocus>
                    @error('email') <small class="field-error">{{ $message }}</small> @enderror
                </div>

                <div class="field-group">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" autocomplete="current-password" required>
                    @error('password') <small class="field-error">{{ $message }}</small> @enderror
                </div>

                <div class="field-group">
                    <label class="remember-field" for="remember">
                        <input id="remember" type="checkbox" name="remember" value="1">
                        Ingat saya
                    </label>
                </div>

                <button class="primary-button full-width" type="submit">Login</button>
            </form>
        </div>
    </section>
@endsection