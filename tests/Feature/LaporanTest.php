<?php

namespace Tests\Feature;

use App\Models\Laporan;
use App\Models\User;
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
            ->assertSee('3 laporan');
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
