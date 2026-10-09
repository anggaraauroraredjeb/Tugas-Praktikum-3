<?php

namespace Database\Seeders;

use App\Models\Laporan;
use Illuminate\Database\Seeder;

class LaporanSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');
        $kecamatan = [
            'Dayeuhkolot',
            'Baleendah',
            'Bojongsoang',
            'Rancaekek',
            'Majalaya',
            'Ciparay',
            'Margaasih',
            'Cileunyi',
            'Katapang',
            'Soreang',
        ];

        for ($i = 0; $i < 15; $i++) {
            $tinggiGenangan = match ($i) {
                0 => $faker->numberBetween(10, 29),
                1 => $faker->numberBetween(30, 70),
                2 => $faker->numberBetween(71, 150),
                default => $faker->numberBetween(10, 150),
            };

            Laporan::create([
                'nama_pelapor' => $faker->name(),
                'lokasi' => $faker->randomElement($kecamatan),
                'tinggi_genangan' => $tinggiGenangan,
                'tanggal_kejadian' => $faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d'),
            ]);
        }
    }
}
