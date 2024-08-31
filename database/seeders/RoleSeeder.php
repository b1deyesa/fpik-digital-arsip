<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    
    public $roles = [
        1 => 'admin',
        2 => 'guest'
    ];
    
    public function run(): void
    {
        foreach ($this->roles as $role) {
            Role::create([
                'name' => $role
            ]);
        }
    }
}
