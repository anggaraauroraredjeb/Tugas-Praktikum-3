<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('laporan', function (Blueprint $table) {
            $table->string('no_hp', 20)->nullable();
            $table->string('kecamatan', 120)->nullable();
            $table->unsignedInteger('tinggi_air')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('foto')->nullable();
            $table->string('status')->default('Menunggu');
        });

        DB::table('laporan')->whereNull('tinggi_air')->update([
            'tinggi_air' => DB::raw('tinggi_genangan'),
        ]);
    }

    public function down(): void
    {
        Schema::table('laporan', function (Blueprint $table) {
            $table->dropColumn([
                'no_hp',
                'kecamatan',
                'tinggi_air',
                'keterangan',
                'foto',
                'status',
            ]);
        });
    }
};