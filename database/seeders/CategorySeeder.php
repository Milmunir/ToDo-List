<?php

namespace Database\Seeders;

use App\Models\category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['id'=>1, 'name'=>'Todo'],
            ['id'=>2, 'name'=>'InProgress'],
            ['id'=>3, 'name'=>'Testing'],
            ['id'=>4, 'name'=>'Done'],
            ['id'=>5, 'name'=>'Pending']
        ];
        foreach ($categories as $value) {
            category::create($value);
        }
    }
}
