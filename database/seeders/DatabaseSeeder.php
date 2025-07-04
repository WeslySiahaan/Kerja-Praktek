<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',          
            'email' => 'test@example.com',
        ]);
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'), // default admin password
            'role' => 'admin'
        ]);
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin1@gmail.com',
            'password' => Hash::make('admin123'), // default admin password
            'role' => 'admin'
        ]);
        User::factory()->create([
            'name' => 'Wesly',
            'email' => 'wesly@gmail.com',
            'password' => Hash::make('wesly123'), // default admin password
            'role' => 'users'
        ]);
        User::factory()->create([
            'name' => 'lusiana',
            'email' => 'lusiana@gmail.com',
            'password' => Hash::make('lusiana123'), // default admin password
            'role' => 'users'
        ]);
        User::factory()->create([
            'name' => 'lusiana',
            'email' => 'angel@gmail.com',
            'password' => Hash::make('angel123'), // default admin password
            'role' => 'users'
        ]);
        User::factory()->create([
            'name' => 'sunanda',
            'email' => 'sunanda@gmail.com',
            'password' => Hash::make('sunanda123'), // default admin password
            'role' => 'users'
        ]);
    }
}
