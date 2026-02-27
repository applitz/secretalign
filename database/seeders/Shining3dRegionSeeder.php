<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class Shining3dRegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('shining3d_region')->insert([

            [
                'name' => 'Asia-Pacific',
                'code' => 'APAC',
                'description' => 'Japan & East Asia users',
                'status' => 'active',
                'api_url' => 'https://tkapi.shining3d.com',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'name' => 'China',
                'code' => 'CN',
                'description' => 'Mainland China users',
                'status' => 'active',
                'api_url' => 'https://hzapi.shining3d.com',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'name' => 'Europe',
                'code' => 'EMEA',
                'description' => 'Recommended for EU countries',
                'status' => 'active',
                'api_url' => 'https://ffapi.shining3d.com',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Russia',
                'code' => 'RU',
                'description' => 'Users located in Russia',
                'status' => 'active',
                'api_url' => 'https://ruapi.shining3d.com',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'name' => 'USA',
                'code' => 'Americas',
                'description' => 'North America users',
                'status' => 'active',
                'api_url' => 'https://sapi.shining3d.com',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
