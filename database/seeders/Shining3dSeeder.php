<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Shining3Details;
class Shining3dSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nodes = ['frankfurt', 'hz', 'ru', 'silicon', 'tokyo'];

        foreach ($nodes as $node) {
            Shining3Details::create([
                'node' => $node,
                'auth_csrf' => null,
                'auth_token' => null,
            ]);
        }

    }
}
