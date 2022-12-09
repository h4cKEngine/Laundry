<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            'ajeje@gmail.com',
            'mrflanagan@gmail.com'
        ];

        foreach ($users as $email) {
            \App\Models\User::firstOrCreate([
                'email' => $email,
            ], [
                'password' => Hash::make('Ciao1234'),
                'nome' => fake()->firstName,
                'cognome' => fake()->lastName,
                'ruolo' => 0,
                'matricola' => fake()->numberBetween(100000, 599999),
                'nazionalita' => 'italian',
                'deleted_at' => NULL
            ]);
        }

        \App\Models\User::firstOrCreate([
            'email' => 'ignazio@gmail.com',
        ], [
                'password' => Hash::make('Ciao1234'),
                'nome' => fake()->firstName,
                'cognome' => fake()->lastName,
                'ruolo' => 1,
                'matricola' => fake()->numberBetween(100000, 599999),
                'nazionalita' => 'italian',
                'deleted_at' => NULL
            ]
        );
    }
}
