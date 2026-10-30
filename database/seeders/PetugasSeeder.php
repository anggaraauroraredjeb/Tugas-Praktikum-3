<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class PetugasSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->count(5)->create();

        User::factory()->create([
            'name' => 'Administrator BPBD',
            'email' => 'admin@bpbd-bandung.test',
            'password' => 'admin123',
        ]);
    }
}