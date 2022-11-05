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
            'nome' => fake()->lastName(),
            'prezzo' => rand(0, 5),
            'durata' => "01:00:00",
            'stato' => 1
        ]);

        \App\Models\WashingProgram::create([
            'nome' => fake()->lastName(),
            'prezzo' => rand(0, 5),
            'durata' => "01:00:00",
            'stato' => 1
        ]);
        
        \App\Models\WashingProgram::create([
            'nome' => fake()->lastName(),
            'prezzo' => rand(0, 5),
            'durata' => "01:00:00",
            'stato' => 1
        ]);
    }
}
