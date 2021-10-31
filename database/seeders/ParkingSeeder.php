<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParkingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('parkings')->insert([
            'kode_tiket' => 'PC001',
            'jenis_kendaraan' => 'Motor',
            'plat_no' => 'B 1578 BAE',
            'durasi' => '1 jam',
            'tarif' => 2000,
            'created_at' => Carbon::now(),
            'updated_at' => '2021-10-30 20:01:00',
        ]);
    }
}
