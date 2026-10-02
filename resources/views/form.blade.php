<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Banjir</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <main class="page-shell">
        <section class="form-card">
            <p class="eyebrow">BPBD Kabupaten Bandung</p>
            <h1>Laporan Banjir</h1>
            <p class="intro">Silakan isi data kejadian banjir dengan lengkap.</p>

            <form action="{{ url('/proses') }}" method="post">
                @csrf
                <div class="field-group">
                    <label for="nama">Nama pelapor</label>
                    <input id="nama" type="text" name="nama" value="{{ old('nama') }}" required>
                </div>

                <div class="field-group">
                    <label for="lokasi">Lokasi kejadian (kecamatan/desa)</label>
                    <input id="lokasi" type="text" name="lokasi" value="{{ old('lokasi') }}" required>
                </div>

                <div class="field-group">
                    <label for="tinggi_genangan">Tinggi genangan air (cm)</label>
                    <input id="tinggi_genangan" type="number" name="tinggi_genangan" min="0" step="1" value="{{ old('tinggi_genangan') }}" required>
                </div>

                <button type="submit">Kirim laporan</button>
            </form>
        </section>
    </main>
</body>
</html>