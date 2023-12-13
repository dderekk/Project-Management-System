<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfileTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('profiles')->insert([
            'studentID'=> 8,
            'GPA' => 6,
            'graduation_year'=> 2027,
            'graduation_trimester' => 3,
            'softwareDeveloper'=> 0,
            'projectManager' => 1,
            'businessAnalyst' => 5,
            'tester' => 4,
            'clientLiaison' => 0,
        ]);
        DB::table('profiles')->insert([
            'studentID'=> 9,
            'GPA' => 5,
            'graduation_year'=> 2028,
            'graduation_trimester' => 1,
            'softwareDeveloper'=> 4,
            'projectManager' => 5,
            'businessAnalyst' => 0,
            'tester' => 4,
            'clientLiaison' => 0,
        ]);
        DB::table('profiles')->insert([
            'studentID'=> 11,
            'GPA' => 4,
            'graduation_year'=> 2026,
            'graduation_trimester' => 3,
            'softwareDeveloper'=> 5,
            'projectManager' => 0,
            'businessAnalyst' => 0,
            'tester' => 5,
            'clientLiaison' => 4,
        ]);

        // Additional data
        for ($i = 12; $i <= 29; $i++) {
            $softwareDeveloper = rand(0, 5);
            $projectManager = rand(0, 5);
            $businessAnalyst = rand(0, 5);
            $tester = rand(0, 5);
            $clientLiaison = rand(0, 5);

            // Ensure at least one role is not zero
            while ($softwareDeveloper == 0 && $projectManager == 0 && $businessAnalyst == 0 && $tester == 0 && $clientLiaison == 0) {
                $softwareDeveloper = rand(0, 5);
                $projectManager = rand(0, 5);
                $businessAnalyst = rand(0, 5);
                $tester = rand(0, 5);
                $clientLiaison = rand(0, 5);
            }

            DB::table('profiles')->insert([
                'studentID'=> $i,
                'GPA' => rand(4, 7),
                'graduation_year'=> rand(2024, 2028),
                'graduation_trimester' => rand(1, 3),
                'softwareDeveloper'=> $softwareDeveloper,
                'projectManager' => $projectManager,
                'businessAnalyst' => $businessAnalyst,
                'tester' => $tester,
                'clientLiaison' => $clientLiaison,
            ]);
        }
    }
}
