<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $classes = [
            ['class_name' => 'Class 5'],
            ['class_name' => 'Class 6'],
            ['class_name' => 'Class 7'],
            ['class_name' => 'Class 8'],
            ['class_name' => 'Class 9'],
            ['class_name' => 'Class 10'],
        ];
    
        foreach ($classes as $class) {
            \App\Models\StudentClass::create($class);
        }
    }
}
