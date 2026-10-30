<?php

namespace Tests\Feature;

use App\Models\Laporan;
use App\Models\User;
use Database\Seeders\PetugasSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_submit_reports_but_cannot_access_report_management(): void
    {
        $this->get(route('laporans.index'))
            ->assertRedirect(route('login'));

        $this->get(route('laporans.create'))
            ->assertOk()
            ->assertSee('Buat laporan');

        $this->post(route('laporans.store'), [
            'nama_pelapor' => 'Warga Bandung',
            'no_hp' => '081234567890',
            'lokasi' => 'Dayeuhkolot',
            'kecamatan' => 'Dayeuhkolot',
            'tinggi_air' => 35,
            'tanggal_kejadian' => '2026-10-08',
        ])->assertOk();

        $this->get('/form')->assertOk();
        $this->post('/proses', [
            'nama' => 'Warga Bandung',
            'lokasi' => 'Dayeuhkolot',
            'tinggi_genangan' => 35,
        ])->assertOk();

        $this->assertDatabaseHas('laporan', ['nama_pelapor' => 'Warga Bandung']);
    }

    public function test_user_can_register_login_view_profile_and_logout(): void
    {
        $response = $this->post(route('register.store'), [
            'name' => 'Petugas Baru',
            'email' => 'petugas@example.test',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $user = User::where('email', 'petugas@example.test')->firstOrFail();

        $response->assertRedirect(route('laporans.index'));
        $this->assertAuthenticatedAs($user);
        $this->assertTrue(Hash::check('password123', $user->password));

        $this->get(route('laporans.create'))->assertOk();

        $this->get(route('profile'))
            ->assertOk()
            ->assertSee('Petugas Baru')
            ->assertSee('petugas@example.test')
            ->assertSee($user->created_at->format('d M Y, H:i'));

        $this->post(route('logout'))->assertRedirect(route('login'));
        $this->assertGuest();

        $this->post(route('login.store'), [
            'email' => 'petugas@example.test',
            'password' => 'password123',
        ])->assertRedirect(route('laporans.index'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_invalid_login_is_rejected_and_registration_validates_inputs(): void
    {
        $this->post(route('login.store'), [
            'email' => 'unknown@example.test',
            'password' => 'incorrect-password',
        ])->assertSessionHasErrors('email');

        $this->post(route('register.store'), [
            'name' => '',
            'email' => 'not-an-email',
            'password' => 'short',
            'password_confirmation' => 'different',
        ])->assertSessionHasErrors(['name', 'email', 'password']);

        $this->assertGuest();
    }

    public function test_petugas_seeder_creates_five_faker_accounts_and_a_hashed_admin(): void
    {
        $this->seed(PetugasSeeder::class);

        $this->assertDatabaseCount('users', 6);
        $this->assertSame(5, User::where('email', '!=', 'admin@bpbd-bandung.test')->count());

        $admin = User::where('email', 'admin@bpbd-bandung.test')->firstOrFail();
        $this->assertSame('Administrator BPBD', $admin->name);
        $this->assertTrue(Hash::check('admin123', $admin->password));
    }
}