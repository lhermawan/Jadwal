<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employee; 

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Employee::insert([
            ['name' => 'Adilla', 'role' => 2],
            ['name' => 'Santi', 'role' => 2],
            ['name' => 'Baiqa', 'role' => 2],
            ['name' => 'Haidar', 'role' => 1],
            ['name' => 'Gagah', 'role' => 1],
            ['name' => 'Khairul', 'role' => 1],
            ['name' => 'Acep', 'role' => 3],
            ['name' => 'Dimas', 'role' => 3],
            ['name' => 'Cucu', 'role' => 3],
            ['name' => 'Pak Aep', 'role' => 3],
            ['name' => 'Pak Totong', 'role' => 3],
            ['name' => 'Aldrian', 'role' => 3],
            // Tambahkan lebih banyak data sesuai kebutuhan
        ]);
    }
}
