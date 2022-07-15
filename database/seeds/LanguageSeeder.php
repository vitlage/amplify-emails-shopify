<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('languages')->delete();
        DB::table('languages')->insert([
            [
                'id' => 1,
                'uid' => '5781b681c1b34',
                'name' => 'English',
                'code' => 'en',
                'region_code' => 'us',
                'status' => 'active',
                'is_default' => 1,
                'created_at' => '2022-01-24 09:44:17',
                'updated_at' => '2022-01-24 09:44:17',
            ],
            [
            'id' => 2,
            'uid' => '581b52d8acdca',
            'name' => 'Spanish',
            'code' => 'es',
            'region_code' => 'es',
            'status' => 'active',
            'is_default' => 0,
            'created_at' => '2022-01-24 09:44:17',
            'updated_at' => '2022-01-24 09:44:17',
        ]
        ]);
    }
}
