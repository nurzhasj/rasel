<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CreateSomeUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()
            ->create([
                'username' => 'samat@gmail.com',
                'password' => Hash::make('secret'),
                'name' => 'Samat Serik',
                'created_at' => Carbon::now(),
            ]);

        User::query()
            ->create([
                'username' => 'berik@gmail.com',
                'password' => Hash::make('secret'),
                'name' => 'Berik Serik',
                'created_at' => Carbon::now(),
            ]);

        User::query()
            ->create([
                'username' => 'erik@gmail.com',
                'password' => Hash::make('secret'),
                'name' => 'Erik Serik',
                'created_at' => Carbon::now(),
            ]);

        User::query()
            ->create([
                'username' => 'alash@gmail.com',
                'password' => Hash::make('secret'),
                'name' => 'Nurzhas Alash',
                'created_at' => Carbon::now(),
            ]);
    }
}
