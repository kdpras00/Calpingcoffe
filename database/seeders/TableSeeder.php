<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed 10 tables
        for ($i = 1; $i <= 10; $i++) {
            $number = str_pad($i, 2, '0', STR_PAD_LEFT); // "01", "02", ...
            $token = hash('sha256', Str::random(40) . $i . $number . now());
            $secureUrl = url('/menu?token=' . $token);

            DB::table('tables')->insert([
                'number'       => $number,
                'qr_code'      => $secureUrl,
                'secure_token' => $token,
                'status'       => 'available',
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }
    }
}
