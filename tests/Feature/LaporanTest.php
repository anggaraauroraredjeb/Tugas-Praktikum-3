<?php

namespace Tests\Feature;

use App\Models\Laporan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LaporanTest extends TestCase
{
    use RefreshDatabase;

    public function test_submission_is_saved_and_shows_confirmation(): void
    {
        $response = $this->post(route('laporans.store'), [
            'nama_pelapor' => 'Siti Aminah',
            'lokasi' => 'Dayeuhkolot',
            'tinggi_genangan' => 45,
            'tanggal_kejadian' => '2026-10-08',
        ]);

        $response->assertOk()
            ->assertSee('Laporan berhasil dikirim.')
            ->assertSee('Siti Aminah')
            ->assertSee('Dayeuhkolot');

        $this->assertDatabaseHas('laporan', [
            'nama_pelapor' => 'Siti Aminah',
            'lokasi' => 'Dayeuhkolot',
            'tinggi_genangan' => 45,
        ]);
        $this->assertSame('2026-10-08', Laporan::firstOrFail()->tanggal_kejadian->format('Y-m-d'));
    }

    public function test_index_displays_database_reports_with_each_flood_status(): void
    {
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
            ->assertSee('3 laporan');
    }
}
