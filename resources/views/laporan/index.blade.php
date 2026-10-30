@extends('layouts.app')

@section('title', 'Daftar laporan')

@section('content')
    <section class="page-heading">
        <div>
            <p class="eyebrow">Pemantauan kejadian</p>
            <h1>Daftar laporan banjir</h1>
            <p class="intro">Pantau laporan genangan yang masuk dari warga.</p>
        </div>
        <a class="primary-button" href="{{ route('laporans.create') }}">+ Buat laporan</a>
    </section>

    <section class="report-list" aria-label="Laporan banjir">
        @if (session('success'))
            <x-alert type="success">{{ session('success') }}</x-alert>
        @endif
        <div class="list-summary">
            <h2>Laporan warga</h2>
            <span>{{ $laporans->total() }} laporan</span>
        </div>
        <div class="report-table-wrap">
            <table class="report-table">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Foto</th>
                        <th scope="col">Pelapor</th>
                        <th scope="col">Lokasi</th>
                        <th scope="col">Tinggi air</th>
                        <th scope="col">Tingkat</th>
                        <th scope="col">Status</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($laporans as $laporan)
                        @php($tinggiAir = $laporan->tinggi_air ?? $laporan->tinggi_genangan)
                        <tr>
                            <td>{{ $laporans->firstItem() + $loop->index }}</td>
                            <td>
                                @if ($laporan->foto)
                                    <a class="table-photo-link" href="{{ asset('storage/'.$laporan->foto) }}" target="_blank" rel="noopener" aria-label="Lihat foto laporan {{ $laporan->id }}">
                                        <img class="table-photo" src="{{ asset('storage/'.$laporan->foto) }}" alt="Foto banjir di {{ $laporan->lokasi }}" loading="lazy">
                                    </a>
                                @else
                                    <span class="table-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <strong class="table-primary-text">{{ $laporan->nama_pelapor }}</strong>
                                @if ($laporan->no_hp)
                                    <span class="table-secondary-text">{{ $laporan->no_hp }}</span>
                                @endif
                            </td>
                            <td>
                                <strong class="table-primary-text">{{ $laporan->lokasi }}</strong>
                                @if ($laporan->kecamatan)
                                    <span class="table-secondary-text">Kec. {{ $laporan->kecamatan }}</span>
                                @endif
                            </td>
                            <td>{{ $tinggiAir }} cm</td>
                            <td>
                                @if ($tinggiAir < 30)
                                    <span class="risk-badge risk-watch">Waspada</span>
                                @elseif ($tinggiAir <= 70)
                                    <span class="risk-badge risk-alert">Siaga</span>
                                @else
                                    <span class="risk-badge risk-danger">Awas</span>
                                @endif
                            </td>
                            <td>
                                <span @class([
                                    'workflow-badge',
                                    'workflow-pending' => $laporan->status === 'Menunggu',
                                    'workflow-processing' => $laporan->status === 'Diproses',
                                    'workflow-complete' => $laporan->status === 'Selesai',
                                ])>{{ $laporan->status }}</span>
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a class="table-action action-view" href="{{ route('laporans.show', $laporan) }}">Lihat</a>
                                    <a class="table-action action-edit" href="{{ route('laporans.edit', $laporan) }}">Edit</a>
                                    <form action="{{ route('laporans.destroy', $laporan) }}" method="post" onsubmit="return confirm('Hapus laporan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="table-action action-delete" type="submit">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="table-empty" colspan="8">
                                <strong>Belum ada laporan</strong>
                                <span>Laporan yang dikirim warga akan muncul di halaman ini.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $laporans->links() }}
    </section>
@endsection
