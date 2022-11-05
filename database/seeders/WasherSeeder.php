<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WasherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Washer::create([
            'marca' => fake()->lastName(),
            'stato' => 1
        ]);

        \App\Models\Washer::create([
            'marca' => fake()->lastName(),
            'stato' => 1
        ]);
    }
}
