<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectFilesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('projectFiles')->insert([
            'project_id' => 2,
            'file_path' => 'products_images/default.pdf',
            'type' => 'pdf',
            'name' => 'testFile'
        ]);
        DB::table('projectFiles')->insert([
            'project_id' => 3,
            'file_path' => 'products_images/default.jpg',
            'type' => 'image',
            'name' => 'testImage'
        ]);
    }
}
