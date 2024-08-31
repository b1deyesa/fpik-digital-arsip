<?php

namespace Database\Seeders;

use App\Models\Data;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public $datas = [
        'Nama'
    ];
    
    public function run(): void
    {
        foreach ($this->datas as $data) {
            Data::create([
                'label' => $data
            ]);
        }
    }
}
