<?php

namespace Tests\Feature;

use App\Models\Laporan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LaporanTest extends TestCase
{
    use RefreshDatabase;

    public function test_submission_is_saved_and_shows_confirmation(): void
    {
        $response = $this->post(route('laporans.store'), [
            'nama_pelapor' => 'Siti Aminah',
            'no_hp' => '081234567890',
            'lokasi' => 'Dayeuhkolot',
            'kecamatan' => 'Dayeuhkolot',
            'tinggi_air' => 45,
            'tanggal_kejadian' => '2026-10-08',
            'keterangan' => 'Air mulai masuk ke rumah.',
        ]);

        $response->assertOk()
            ->assertSee('Laporan berhasil dikirim.')
            ->assertSee('Siti Aminah')
            ->assertSee('Dayeuhkolot');

        $this->assertDatabaseHas('laporan', [
            'nama_pelapor' => 'Siti Aminah',
            'no_hp' => '081234567890',
            'lokasi' => 'Dayeuhkolot',
            'kecamatan' => 'Dayeuhkolot',
            'tinggi_genangan' => 45,
        ]);
        $this->assertSame('2026-10-08', Laporan::firstOrFail()->tanggal_kejadian->format('Y-m-d'));
        $this->assertSame('Menunggu', Laporan::firstOrFail()->status);
        $this->assertSame(45, Laporan::firstOrFail()->tinggi_air);
    }

    public function test_index_displays_database_reports_with_each_flood_status(): void
    {
        $this->actingAs(User::factory()->create());

        foreach ([20, 50, 100] as $tinggiGenangan) {
            Laporan::create([
                'nama_pelapor' => 'Warga',
                'lokasi' => 'Kabupaten Bandung',
                'tinggi_genangan' => $tinggiGenangan,
                'tanggal_kejadian' => '2026-10-08',
            ]);
        }

        $this->get(route('laporans.index'))
            ->assertOk()
            ->assertSee('Waspada')
            ->assertSee('Siaga')
            ->assertSee('Awas')
            ->assertSee('3 laporan')
            ->assertSee('<th scope="col">Aksi</th>', false)
            ->assertSee('Edit')
            ->assertSee('Hapus');
    }

    public function test_officers_can_edit_status_replace_photo_and_delete_report(): void
    {
        Storage::fake('public');
        $oldPhoto = UploadedFile::fake()->create('old.jpg', 10, 'image/jpeg');
        $oldPhotoPath = $oldPhoto->store('laporan', 'public');
        $laporan = Laporan::create([
            'nama_pelapor' => 'Warga',
            'no_hp' => '081234567890',
            'lokasi' => 'Dayeuhkolot',
            'kecamatan' => 'Dayeuhkolot',
            'tinggi_air' => 35,
            'tinggi_genangan' => 35,
            'tanggal_kejadian' => '2026-10-08',
            'keterangan' => 'Air di jalan.',
            'foto' => $oldPhotoPath,
            'status' => 'Menunggu',
        ]);

        $this->get(route('laporans.edit', $laporan))
            ->assertRedirect(route('login'));

        $this->actingAs(User::factory()->create())
            ->get(route('laporans.edit', $laporan))
            ->assertOk()
            ->assertSee('Diproses');

        $this->put(route('laporans.update', $laporan), [
            'nama_pelapor' => 'Warga',
            'no_hp' => '081234567890',
            'lokasi' => 'Dayeuhkolot',
            'kecamatan' => 'Dayeuhkolot',
            'tinggi_air' => 50,
            'tanggal_kejadian' => '2026-10-08',
            'keterangan' => 'Air bertambah.',
            'status' => 'Diproses',
        ])->assertRedirect(route('laporans.show', $laporan));

        $this->assertTrue(Storage::disk('public')->exists($oldPhotoPath));
        $this->assertDatabaseHas('laporan', [
            'id' => $laporan->id,
            'tinggi_air' => 50,
            'status' => 'Diproses',
        ]);

        $newPhoto = UploadedFile::fake()->create('new.jpg', 10, 'image/jpeg');
        $this->put(route('laporans.update', $laporan), [
            'nama_pelapor' => 'Warga',
            'no_hp' => '081234567890',
            'lokasi' => 'Dayeuhkolot',
            'kecamatan' => 'Dayeuhkolot',
            'tinggi_air' => 50,
            'tanggal_kejadian' => '2026-10-08',
            'keterangan' => 'Air bertambah.',
            'status' => 'Selesai',
            'foto' => $newPhoto,
        ])->assertRedirect(route('laporans.show', $laporan));

        $laporan->refresh();
        $this->assertFalse(Storage::disk('public')->exists($oldPhotoPath));
        $this->assertTrue(Storage::disk('public')->exists($laporan->foto));

        $newPhotoPath = $laporan->foto;
        $this->delete(route('laporans.destroy', $laporan))
            ->assertRedirect(route('laporans.index'))
            ->assertSessionHas('success', 'Laporan berhasil dihapus.');

        $this->assertFalse(Storage::disk('public')->exists($newPhotoPath));
        $this->assertDatabaseMissing('laporan', ['id' => $laporan->id]);
    }

    public function test_legacy_form_and_result_use_the_shared_portal_shell(): void
    {
        $this->get('/form')
            ->assertOk()
            ->assertSee('aria-label="Navigasi utama"', false)
            ->assertSee('Login')
            ->assertSee('Register')
            ->assertSee('Buat laporan')
            ->assertSee('name="nama"', false);

        $this->post('/proses', [
            'nama' => 'Dewi Lestari',
            'lokasi' => 'Baleendah',
            'tinggi_genangan' => 35,
        ])
            ->assertOk()
            ->assertSee('BPBD Kabupaten Bandung')
            ->assertSee('LaporBanjir')
            ->assertSee('Dewi Lestari')
            ->assertSee('Baleendah')
            ->assertSee('35 cm');
    }

    public function test_shared_navigation_marks_the_current_section(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get('/')
            ->assertOk()
            ->assertSee('href="' . route('laporans.index') . '" class="is-active"', false);

        $reportsResponse = $this->get('/laporan');
        $reportsResponse
            ->assertOk()
            ->assertSee('href="' . route('laporans.index') . '" class="is-active"', false)
            ->assertSee('aria-current="page"', false);

        $laporan = Laporan::create([
            'nama_pelapor' => 'Warga',
            'lokasi' => 'Kabupaten Bandung',
            'tinggi_genangan' => 20,
            'tanggal_kejadian' => '2026-10-08',
        ]);
        $this->get(route('laporans.show', $laporan))
            ->assertOk()
            ->assertSee('href="' . route('laporans.index') . '" class="is-active"', false);

        $createResponse = $this->get(route('laporans.create'));
        $createResponse
            ->assertOk()
            ->assertSee('href="' . route('laporans.create') . '" class="is-active"', false)
            ->assertSee('aria-current="page"', false);
    }
}
