<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User; //panggil model
use Illuminate\Database\Seeder; 


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *@return mixed void
     */

    public function run()
    {
        //memasukan data user admin ke database
        User::create([
            'nama' => 'Administrator',
            'email' => 'admin@admin.com',
            'role' => 'admin',
            'password' => 'admin', //isi pasword akan di hash dengan algoritma bcrypt
            'status' => 'aktif',
            'last_login' => now() //built in library untuk menampilkan tanggal saat ini 
        ]);
       //panggil UserFactory, generate sebanyak 50 data 
        // User::factory()->count(50)->create();
    }
}
