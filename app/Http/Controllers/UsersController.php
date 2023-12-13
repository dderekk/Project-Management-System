<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allUsers=User::all();
        $students = User::where('type', 'Student')->get();
        $InPs = User::where('type', 'Industry Partner')->paginate(5);
        return view('user.index')->with('allUsers',$allUsers)->with('students',$students)->with('InPs',$InPs);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {   
        $userDetail=User::find($id);
        $userproject = User::find($id)->project;
        return view('user.InpDetails')->with('usersDetails',$userDetail)->with('userproject',$userproject);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Show details of all student
     */
    public function showStudents()
    {
        $inps = User::where('type', 'InP')->where('is_approved', false)->get();
        return view('teacher.show_inps', compact('inps'));
    }

    /**
     * Approve the Inp
     */
    public function approveInp($id)
    {
        $inp = User::find($id);
        if (!$inp || $inp->type !== 'Industry Partner') {
            return redirect()->back()->with('error', 'Industry Partner not found.');
        }

        $inp->is_approved = 1;
        $inp->save();

        return redirect()->back()->with('success', 'InP approved successfully.');
    }

    /**
     * Auto Assign function!
     */
    public function autoAssign() {

        // Define an array of roles
        $rolesArray = [
            'softwareDeveloper',
            'projectManager',
            'businessAnalyst',
            'tester',
            'clientLiaison'
        ];
        
        // Access to all students and programmes
        $students = User::where('type', 'Student')->has('application')->with('profile')->get();
        $projects = Project::all();
    
        // Initialising the Student Availability Array
        $studentAvailability = [];
        foreach ($students as $student) {
            $studentID = $student->id;
            $studentAvailability[$studentID] = [
                'availability' => [],  // This will store year-trimester pairs
                'gpa' => $student->profile->GPA,  // Assuming each student has a 'gpa' attribute
                'roles' => []  // We will populate this later
            ];
            $applications = $student->application;
            foreach ($applications as $application) {
                $project = Project::find($application->projectID);
                if ($project) {
                    $year = $project->year;
                    $trimester = $project->trimester;
                    if (!isset($studentAvailability[$studentID]['availability'][$year])) {
                        $studentAvailability[$studentID]['availability'][$year] = [];
                    }
                    if (!in_array($trimester, $studentAvailability[$studentID]['availability'][$year])) {
                        $studentAvailability[$studentID]['availability'][$year][] = $trimester;
                    }
                }
            }
            // Populate roles for each student
            foreach ($rolesArray as $role) {
                if (isset($student->profile->$role) && $student->profile->$role > 0) {
                    $studentAvailability[$studentID]['roles'][$role] = $student->profile->$role;
                }
            }
        }
        $studentAvailabilitycopy = unserialize(serialize($studentAvailability));
    
        // While there are students in $studentAvailability
        while (!empty($studentAvailability)) {
            // Get all possible years (从$studentAvailability获取)
            $years = array_keys(array_reduce($studentAvailability, function ($carry, $item) {
                return $carry + $item['availability'];
            }, []));
            sort($years);
    
            foreach ($years as $year) {
                $trimesters = array_reduce($studentAvailability, function ($carry, $item) use ($year) {
                    return isset($item['availability'][$year]) ? array_merge($carry, $item['availability'][$year]) : $carry;
                }, []);
                $trimesters = array_unique($trimesters);  // Remove duplicates
    
                foreach ($trimesters as $trimester) {
                    // For each Trimester in each year, we find the number of students who have applied in this term in this year.
                    $studentsAppliedThisTerm = [];
                    foreach ($studentAvailability as $studentID => $availability) {
                        if (isset($availability['availability'][$year]) && in_array($trimester, $availability['availability'][$year])) {
                            $studentsAppliedThisTerm[$studentID] = [
                                'gpa' => $availability['gpa'],
                                'roles' => $availability['roles']
                            ];
                        }
                    }
                    // Find the projects for this year, trimester, and sort them in order from eazy to hard, with their headcount requirement team_size.
                    $projectsThisTerm = $projects->where('year', $year)->where('trimester', $trimester)->sortBy('difficulty_level')->sortBy('team_size')->all();
                    // Find the role with the lowest number of students in this term from $studentsAppliedThisTerm
                    $roleCountsThisTerm = array_fill_keys($rolesArray, 0);
                    foreach ($studentsAppliedThisTerm as $studentInfo) {
                        foreach ($studentInfo['roles'] as $role => $preference) {
                            $roleCountsThisTerm[$role]++;
                        }
                    }
                    asort($roleCountsThisTerm);
                    $leastSelectedRole = key($roleCountsThisTerm);
                    // Find roles with only 1 application from $studentsAppliedThisTerm
                    $studentsWithSingleApplication = [];
                    foreach ($studentsAppliedThisTerm as $studentID => $studentInfo) {
                        $student = $students->where('id', $studentID)->first();
                        if ($student->application->count() == 1) {
                            $studentsWithSingleApplication[] = $studentID;
                        }
                    }
                    // Check if the number of least selected roles is 0
                    if ($roleCountsThisTerm[$leastSelectedRole] == 0) {
                        // No projects are scheduled for this semester
                        foreach ($studentsAppliedThisTerm as $studentID => $info) {
                            // Remove this year's semester data from $studentAvailability
                            unset($studentAvailability[$studentID]['availability'][$year][$trimester]);
                            // Remove the student entirely from $studentAvailability if the student has no other available semester
                            if (empty($studentAvailability[$studentID]['availability'][$year])) {
                                unset($studentAvailability[$studentID]['availability'][$year]);
                            }
                            if (empty($studentAvailability[$studentID]['availability'])) {
                                unset($studentAvailability[$studentID]);
                            }
                        }
                        // If there are students in $studentsWithSingleApplication, remove them from $studentAvailability as well.
                        foreach ($studentsWithSingleApplication as $studentID) {
                            unset($studentAvailability[$studentID]);
                        }
                        continue;  // Skip follow-up processing for this semester
                    }


                    // Find all students with the $leastSelectedRole role
                    $studentsWithLeastRole = [];
                    foreach ($studentsAppliedThisTerm as $studentID => $studentInfo) {
                        if (isset($studentInfo['roles'][$leastSelectedRole])) {
                            $studentsWithLeastRole[] = $studentID;
                        }
                    }
                    
                    $allCombinations = [];
                    $maxScore = -INF;
                    $chosenProject = [];
                    $assignedStudent = [];

                    foreach ($studentsWithLeastRole as $studentOne) {
                        foreach ($projectsThisTerm as $projectOne) {
                            // If this item is already selected, skip the
                            if (in_array($projectOne->id, $chosenProject)) {
                                continue;
                            }

                            $combination = [$studentOne]; // At the beginning, only $studentLeastRole is in the portfolio

                            foreach ($studentsAppliedThisTerm as $otherStudent => $value) {
                                // If this student has already been selected, skip the
                                if (in_array($otherStudent, $assignedStudent) || $otherStudent == $studentOne) {
                                    continue;
                                }

                                if (count($combination) < $projectOne->team_size) {
                                    $combination[] = $otherStudent;
                                    // Adding combinations to the $allCombinations array
                                    $currentScore = $this->tryCombination($combination, $studentAvailability, $projectOne);
                                    if ($currentScore > $maxScore) {
                                        $maxScore = $currentScore;
                                        $currentCombinations=[];
                                        $currentCombinations[$projectOne->id] = $combination;
                                    }
                                } else {
                                    break; // If the size of the combination has reached $projectOne->team_size, jump out of the loop
                                }
                            }
                        }
                        // Add this project and student to the selected list
                        $chosenProject[] = key($currentCombinations);
                        $assignedStudent = array_merge($assignedStudent, current($currentCombinations));
                        $allCombinations = $allCombinations + $currentCombinations;
                    }
                    
                    // Allocation using the optimal combination
                    foreach ($allCombinations as $projectId => $studentIds) {
                        foreach ($studentIds as $studentId) {
                            // Using Eloquent model to update the user's assigned_project_id field
                            $user = User::find($studentId);
                            if ($user) {
                                $user->assigned_project_id = $projectId;
                                $user->save();
                    
                                // Remove the assigned student from $studentAvailability
                                unset($studentAvailability[$studentId]);
                            }
                        }
                    }
                }
            }
            // Check if there are still students in $studentAvailability
            if (!empty($studentAvailability)) {
                foreach ($studentAvailability as $studentId => $availability) {
                    $student = User::find($studentId);
                    if ($student) {
                        // Get the student's applications
                        $applications = $student->application;
                        foreach ($applications as $application) {
                            $projectId = $application->projectID;
                            // Check if the project is not already assigned to another student
                            if (!in_array($projectId, $chosenProject)) {
                                $student->assigned_project_id = $projectId;
                                $student->save();

                                // Add the project to the chosen projects list to avoid assigning it to another student
                                $chosenProject[] = $projectId;

                                // Remove the assigned student from $studentAvailability
                                unset($studentAvailability[$studentId]);
                                break; // Break out of the inner loop once the student is assigned
                            }
                        }
                    }
                }
            }

        }
        // Before returning, iterate over all projects and find the ones with only one student assigned
        $projectsWithSingleStudent = [];
        $studentsWithProfilesAssignedToSingleProject = [];
        foreach ($projects as $project) {
            $assignedStudentsToProject = User::with('profile')->where('assigned_project_id', $project->id)->get();
            if ($assignedStudentsToProject->count() == 1) {
                $projectsWithSingleStudent[] = $project;
                $student = $assignedStudentsToProject->first();
                $studentsWithProfilesAssignedToSingleProject[] = [
                    'student' => $student,
                    'profile' => $student->profile
                ];

                // Add the student to $studentAvailability
                $studentID = $student->id;
                $studentAvailability[$studentID] = [
                    'availability' => [],  // This will store year-trimester pairs
                    'gpa' => $student->profile->GPA,  // Assuming each student has a 'gpa' attribute
                    'roles' => []  // We will populate this later
                ];
                $applications = $student->application;
                foreach ($applications as $application) {
                    $project = Project::find($application->projectID);
                    if ($project) {
                        $year = $project->year;
                        $trimester = $project->trimester;
                        if (!isset($studentAvailability[$studentID]['availability'][$year])) {
                            $studentAvailability[$studentID]['availability'][$year] = [];
                        }
                        if (!in_array($trimester, $studentAvailability[$studentID]['availability'][$year])) {
                            $studentAvailability[$studentID]['availability'][$year][] = $trimester;
                        }
                    }
                }
                // Populate roles for each student
                foreach ($rolesArray as $role) {
                    if (isset($student->profile->$role) && $student->profile->$role > 0) {
                        $studentAvailability[$studentID]['roles'][$role] = $student->profile->$role;
                    }
                }
            }
        }
        // Iterate over students in $studentAvailability
        foreach ($studentAvailability as $studentId => $studentData) {
            $bestProject = 0;
            $maxScore = -INF;
            // For each student, iterate over their availability
            foreach ($studentData['availability'] as $year => $trimesters) {
                foreach ($trimesters as $trimester) {
                    // Fetch all projects for this year and trimester
                    $projectsForThisTerm = $projects->filter(function ($project) use ($year, $trimester) {
                        return $project->year == $year && $project->trimester == $trimester;
                    });
                    
                    foreach ($projectsForThisTerm as $project) {
                        $combination = User::where('assigned_project_id', $project->id)
                       ->where('id', '!=', $studentId)->pluck('id')->toArray();
                        // If $combination is empty, skip to the next iteration
                        if (empty($combination)) {
                            continue;
                        }
                        array_push($combination, $studentId);
                        $currentScore = $this->tryCombination($combination, $studentAvailabilitycopy, $project);
                                    if ($currentScore > $maxScore) {
                                        $maxScore = $currentScore;
                                        $bestProject = $project->id;
                                    }
                    }
                }
            }
            
            if($bestProject == 0){
                continue;
            }


            // Assign the $bestProject to that student
            $student = User::find($studentId);
            if ($student) {
                $student->assigned_project_id = $bestProject;
                
                $student->save();
            }
            
            
        }

        
        $assignedStudents = User::whereNotNull('assigned_project_id')->get();
        return redirect('/plist');

    }

    // Recursive function to try and score all possible student combinations
    private function tryCombination($currentCombination, $studentAvailability, $projectOne) {
        // $currentCombination = [xxx,xxx,xxx] just all id, $projectOne is project details
        global $maxScore, $bestCombinationForAllProjects;

        // Define an array of roles
        $rolesArray = [
            'softwareDeveloper',
            'projectManager',
            'businessAnalyst',
            'tester',
            'clientLiaison'
        ];

        $currentScore = 0; // Initialise the score for the current combination

        // Calculate the average of the GPAs of all students in the portfolio
        $averageGPA = 0;
        foreach ($currentCombination as $studentID) {
            $averageGPA += $studentAvailability[$studentID]['gpa'];
        }
        $averageGPA /= count($currentCombination);

        // Calculate the mean square deviation
        $meanSquareError = 0;
        foreach ($currentCombination as $studentID) {
            $difference = $studentAvailability[$studentID]['gpa'] - $averageGPA;
            $meanSquareError += $difference * $difference;
        }
        $meanSquareError /= count($currentCombination);

        // If the mean square deviation is less than 0.25, add 50 points
        if ($meanSquareError <= 0.25) {
            $currentScore += 50;
        }
        if ($meanSquareError >= 1.25) {
            $currentScore -= 20;
        }

        // Check that the student's roles in $currentCombination cover all of $rolesArray.
        $coveredRoles = [];
        foreach ($currentCombination as $studentID) {
            $roles = $studentAvailability[$studentID]['roles'];
            $coveredRoles = array_merge($coveredRoles, array_keys($roles));
        }
        $coveredRoles = array_unique($coveredRoles); // Remove duplicate roles

        if (count(array_diff($rolesArray, $coveredRoles)) == 0) {
            // If all the characters are covered, add 100 points
            $currentScore += 100;
        }else{
            $currentScore -= 50;
        }

        // Check that each student ID in $currentCombination applies this ProjectOne.
        foreach ($currentCombination as $studentID) {
            $student = User::find($studentID);
            if ($student && $student->application->where('projectID', $projectOne->id)->count() > 0) {
                // If yes, +1 mark for each one.
                $currentScore += 2;
            }
        }

        return $currentScore;
    }

    

}
