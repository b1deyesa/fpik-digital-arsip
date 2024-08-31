<?php

namespace Database\Seeders;

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
        $this->call([
            RoleSeeder::class,
            DataSeeder::class
        ]);
        
        // \App\Models\User::factory(10)->create();

        \App\Models\User::create([
            'role_id' => 1,
            'nip' => '35200003',
            'password' => Hash::make('magox1905')
        ]);
    }
}
