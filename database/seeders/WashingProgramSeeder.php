<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WashingProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\WashingProgram::create([
            'nome' => "Empty",
            'prezzo' => rand(0, 1),
            'durata' => "00:30:00",
            'stato' => 1
        ]);

        \App\Models\WashingProgram::create([
            'nome' => "Color",
            'prezzo' => rand(2, 5),
            'durata' => "01:30:00",
            'stato' => 1
        ]);
        
        \App\Models\WashingProgram::create([
            'nome' => "White",
            'prezzo' => rand(2, 5),
            'durata' => "01:00:00",
            'stato' => 1
        ]);

        \App\Models\WashingProgram::create([
            'nome' => "Black",
            'prezzo' => rand(2, 5),
            'durata' => "01:00:00",
            'stato' => 1
        ]);
    }
}
