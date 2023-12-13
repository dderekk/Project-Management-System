<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApplicationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('application')->insert([
            'justification'=>'David Invite me',
            'studentID' => 8,
            'projectID'=> 2,
        ]);
        DB::table('application')->insert([
            'justification'=>"SQL Server uses the bit data type that stores 0, 1, and NULL values that can be used instead of the TRUE, FALSE, and NULL values. In this tutorial, we will teach several examples to select and insert values.",
            'studentID' => 9,
            'projectID'=> 2,
        ]);
        DB::table('application')->insert([
            'justification'=>"DBMSs because it only uses 1 bit",
            'studentID' => 11,
            'projectID'=> 2,
        ]);

         // Additional data
         for ($i = 12; $i <= 29; $i++) {
            $studentProfile = DB::table('profiles')->where('studentID', $i)->first();
            $applicationsCount = rand(1, 3); // Each student can have 1 to 3 applications
            $appliedProjects = []; // To keep track of projects the student has already applied to

            for ($j = 0; $j < $applicationsCount; $j++) {
                $attempts = 0;
                $maxAttempts = 200; // Limit the number of attempts to find a suitable project
                $inserted = false;

                while (!$inserted && $attempts < $maxAttempts) {
                    $project = DB::table('projects')->inRandomOrder()->first();

                    // Check if student has already applied to this project
                    if (in_array($project->id, $appliedProjects)) {
                        $attempts++;
                        continue;
                    }

                    // Check GPA and project complexity
                    if (($studentProfile->GPA > 5 && $project->complexity == 'hard') ||
                        ($studentProfile->GPA > 4 && $project->complexity == 'moderate') ||
                        $project->complexity == 'easy') {

                        // Check project year and trimester with student's graduation year and trimester
                        if ($project->year < $studentProfile->graduation_year ||
                            ($project->year == $studentProfile->graduation_year && $project->trimester <= $studentProfile->graduation_trimester)) {

                            DB::table('application')->insert([
                                'justification' => 'Interested in this project',
                                'studentID' => $i,
                                'projectID' => $project->id,
                            ]);
                            $appliedProjects[] = $project->id; // Add project to the list of projects the student has applied to
                            $inserted = true;
                        }
                    }
                    $attempts++;
                }
            }
        }
    }
}
