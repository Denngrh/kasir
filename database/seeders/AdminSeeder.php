<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
        DB::table('users')->insert([
        [
        'username' => 'admin',
        'nama_petugas' => 'ki',
        'email' => 'admin@gmail.com',
        'password' => bcrypt('admin'),
        'role' => 'admin',
        ],
        [
        'username' => 'petugas',
        'nama_petugas' => 'baden nugraha',
        'email' => 'petugas@gmail.com',
        'password' => bcrypt('petugas'),
        'role' => 'petugas',
        ],
     ]);
    }
}
