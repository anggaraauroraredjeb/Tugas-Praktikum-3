<article class="report-row {{ $laporan->foto ? 'has-thumbnail' : '' }}">
    @if ($laporan->foto)
        <a class="report-thumbnail" href="{{ asset('storage/'.$laporan->foto) }}" target="_blank" rel="noopener" aria-label="Lihat foto laporan">
            <img src="{{ asset('storage/'.$laporan->foto) }}" alt="Foto banjir di {{ $laporan->lokasi }}" loading="lazy">
        </a>
    @endif
    <div class="report-main">
        <div class="report-heading">
            <h2>{{ $laporan->lokasi }}</h2>
            @if ($laporan->tinggi_genangan < 30)
                <span class="status status-watch">Waspada</span>
            @elseif ($laporan->tinggi_genangan <= 70)
                <span class="status status-alert">Siaga</span>
            @else
                <span class="status status-danger">Awas</span>
            @endif
            <span class="status status-workflow">{{ $laporan->status }}</span>
        </div>
        <p class="report-meta">{{ $laporan->kecamatan ? $laporan->kecamatan.' · ' : '' }}Dilaporkan oleh {{ $laporan->nama_pelapor }} · {{ $laporan->created_at->format('d-m-Y H:i') }}</p>
    </div>
    <div class="report-water">
        <strong>{{ $laporan->tinggi_air ?? $laporan->tinggi_genangan }} <small>cm</small></strong>
        <span>Tinggi genangan</span>
    </div>
    <a class="text-link" href="{{ route('laporans.show', $laporan->id) }}">Lihat detail <span aria-hidden="true">→</span></a>
</article>
