<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
        //panggil semua class untuk di generate seed nya
        $this->call([
            UserSeeder::class
        ]);

    }
}
