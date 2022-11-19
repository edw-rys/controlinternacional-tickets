<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB; 

class FootertextSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('footertexts')->insert([
            'copyright' => '<p class="mb-0">Copyright © '. date('Y').' <a href="https://edw-dev.com/"> Uhelp </a>. Developed by <a href="https://edw-dev.com/">EdwDev</a></p>',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
