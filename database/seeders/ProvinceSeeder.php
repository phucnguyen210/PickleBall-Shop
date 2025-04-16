<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinceSeeder extends Seeder
{
    public function run()
    {
        $json = file_get_contents(database_path('data/provinces.json'));
        $provinces = json_decode($json, true);

        foreach ($provinces as $province) {
            DB::table('provinces')->insert([
                'code' => $province['code'],
                'name' => $province['name'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
