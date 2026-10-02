<article class="report-row">
    <div class="report-main">
        <div class="report-heading">
            <h2>{{ $laporan['lokasi'] }}</h2>
            @if ($laporan['tinggi_genangan'] < 30)
                <span class="status status-watch">Waspada</span>
            @elseif ($laporan['tinggi_genangan'] <= 70)
                <span class="status status-alert">Siaga</span>
            @else
                <span class="status status-danger">Awas</span>
            @endif
        </div>
        <p class="report-meta">Dilaporkan oleh {{ $laporan['nama'] }} · {{ date('d-m-Y H:i', strtotime($laporan['created_at'])) }}</p>
    </div>
    <div class="report-water">
        <strong>{{ $laporan['tinggi_genangan'] }} <small>cm</small></strong>
        <span>Tinggi genangan</span>
    </div>
    <a class="text-link" href="{{ route('laporans.show', $laporan['id']) }}">Lihat detail <span aria-hidden="true">→</span></a>
</article>
