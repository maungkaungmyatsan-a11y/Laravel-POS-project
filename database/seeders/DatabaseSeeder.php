<?php

namespace Database\Seeders;

use App\Models\User;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();


// create superadmin account for project
        User::factory()->create([
            'name' => 'Super Admin Account',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('superadmin123'),
            'role' => 'superadmin',
            'provider' => 'simple'
        ]);
    }
}
