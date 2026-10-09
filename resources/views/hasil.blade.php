<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Laporan</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <main class="page-shell">
        <section class="result-card">
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
        </section>
    </main>
</body>
</html>