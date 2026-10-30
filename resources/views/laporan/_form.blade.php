<form action="{{ $laporan ? route('laporans.update', $laporan) : route('laporans.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    @if ($laporan)
        @method('PUT')
    @endif

    <div class="field-group">
        <label for="nama_pelapor">Nama pelapor</label>
        <input id="nama_pelapor" type="text" name="nama_pelapor" value="{{ old('nama_pelapor', $laporan?->nama_pelapor) }}" maxlength="255" required>
        @error('nama_pelapor') <small class="field-error">{{ $message }}</small> @enderror
    </div>

    <div class="field-group">
        <label for="no_hp">Nomor HP</label>
        <input id="no_hp" type="tel" name="no_hp" value="{{ old('no_hp', $laporan?->no_hp) }}" maxlength="20" required>
        @error('no_hp') <small class="field-error">{{ $message }}</small> @enderror
    </div>

    <div class="field-group">
        <label for="kecamatan">Kecamatan</label>
        <input id="kecamatan" type="text" name="kecamatan" value="{{ old('kecamatan', $laporan?->kecamatan) }}" maxlength="120" required>
        @error('kecamatan') <small class="field-error">{{ $message }}</small> @enderror
    </div>

    <div class="field-group">
        <label for="lokasi">Lokasi kejadian</label>
        <input id="lokasi" type="text" name="lokasi" value="{{ old('lokasi', $laporan?->lokasi) }}" maxlength="255" required>
        @error('lokasi') <small class="field-error">{{ $message }}</small> @enderror
    </div>

    <div class="field-group">
        <label for="tanggal_kejadian">Tanggal kejadian</label>
        <input id="tanggal_kejadian" type="date" name="tanggal_kejadian" value="{{ old('tanggal_kejadian', $laporan?->tanggal_kejadian?->toDateString() ?? now()->toDateString()) }}" required>
        @error('tanggal_kejadian') <small class="field-error">{{ $message }}</small> @enderror
    </div>

    <div class="field-group">
        <label for="tinggi_air">Tinggi genangan air (cm)</label>
        <input id="tinggi_air" type="number" name="tinggi_air" min="0" max="500" step="1" value="{{ old('tinggi_air', $laporan?->tinggi_air ?? $laporan?->tinggi_genangan) }}" required>
        @error('tinggi_air') <small class="field-error">{{ $message }}</small> @enderror
    </div>

    <div class="field-group">
        <label for="keterangan">Keterangan</label>
        <textarea id="keterangan" name="keterangan" rows="4" maxlength="2000">{{ old('keterangan', $laporan?->keterangan) }}</textarea>
        @error('keterangan') <small class="field-error">{{ $message }}</small> @enderror
    </div>

    @if ($laporan)
        <div class="field-group">
            <label for="status">Status penanganan</label>
            <select id="status" name="status" required>
                @foreach (['Menunggu', 'Diproses', 'Selesai'] as $status)
                    <option value="{{ $status }}" @selected(old('status', $laporan->status) === $status)>{{ $status }}</option>
                @endforeach
            </select>
            @error('status') <small class="field-error">{{ $message }}</small> @enderror
        </div>
    @endif

    <div class="field-group">
        <label for="foto">Foto bukti (JPG, JPEG, atau PNG, maksimal 2 MB)</label>
        <input id="foto" type="file" name="foto" accept="image/jpeg,image/png">
        @error('foto') <small class="field-error">{{ $message }}</small> @enderror
        @if ($laporan?->foto)
            <p class="current-photo">Foto saat ini: <a href="{{ asset('storage/'.$laporan->foto) }}" target="_blank" rel="noopener">Lihat foto</a></p>
        @endif
    </div>

    <button class="primary-button full-width" type="submit">{{ $laporan ? 'Simpan perubahan' : 'Kirim laporan' }}</button>
</form>