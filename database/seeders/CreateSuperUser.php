<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class CreateSuperUser extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superUser = User::query()
            ->create([
                'username' => 'manager@gmail.com',
                'password' => Hash::make('secret'),
                'name' => 'Manager',
                'created_at' => Carbon::now(),
            ]);

        Role::create([
            'name' => 'super-user',
            'created_at' => Carbon::now(),
        ]);

        $superUser->assignRole('super-user');
    }
}
