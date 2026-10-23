@extends('layouts.app')

@section('title', 'Profil petugas')

@section('content')
    <section class="form-wrap">
        <div class="page-heading compact-heading">
            <div>
                <p class="eyebrow">Akun aktif</p>
                <h1>Profil Petugas</h1>
                <p class="intro">Informasi akun yang sedang digunakan.</p>
            </div>
        </div>

        <div class="form-card">
            <div class="field-group">
                <label>Nama</label>
                <p>{{ $user->name }}</p>
            </div>
            <div class="field-group">
                <label>Email</label>
                <p>{{ $user->email }}</p>
            </div>
            <div class="field-group">
                <label>Akun dibuat</label>
                <p>{{ $user->created_at->format('d M Y, H:i') }}</p>
            </div>
        </div>
    </section>
@endsection