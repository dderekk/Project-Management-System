<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Project;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{

    /**
     * Middleware to ensure only students can create an application
     * Middleware to check if the profile is created
     */
    public function __construct()
    {
        // Middleware to ensure only students can create an application
        $this->middleware('Student')->only(['create', 'store']);
        $this->middleware('ensureProfileCreated')->only(['create', 'store']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {   
        $allProjects=Project::all();
        $error = session('error', ''); // Get the error message from the session
        $project_id = $request->project_id;
        return view('application.create_form')->with('allProjects', $allProjects)->with('error', $error)->with('project_id',$project_id);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'justification' => 'required',
        ]);
        // complexity
        $projectComplexity = Project::where('id', $request->project)->value('complexity');

        // GPA
        $studentGPA = Auth::user()->GPA;

        // based on the complexity of the project
        switch ($projectComplexity) {
            case 'hard':
                if ($studentGPA < 5) {
                    return redirect('/application/create')->with('error', 'Your GPA must be greater than 5 to apply for this project.');
                }
                break;
            case 'Moderate':
                if ($studentGPA < 4) {
                    return redirect('/application/create')->with('error', 'Your GPA must be greater than 4 to apply for this project.');
                }
                break;
            case 'easy':
                break;
            default:
                break;
        }

        // Graduation date
        $studentGraduationYear = Auth::user()->graduation_year;
        $studentGraduationTrimester = Auth::user()->graduation_trimester;
        // Project date
        $projectYear = Project::where('id', $request->project)->value('year');
        $projectTrimester = Project::where('id', $request->project)->value('trimester');

        if ($studentGraduationYear < $projectYear || ($studentGraduationYear == $projectYear && $studentGraduationTrimester < $projectTrimester)) {
            return redirect('/application/create')->with('error', 'Your expected graduation date does not meet the requirements of the selected project.');
        }

        // Check if the student has already applied for the same project
        $existingApplication = Application::where('studentID', auth()->id())
                                          ->where('projectID', $request->project)
                                          ->first();
        if ($existingApplication) {
            return redirect('/application/create')->with('error', 'You have already applied for this project.');
        }

        // Check if the student has already applied for 3 projects
        $applicationsCount = Application::where('studentID', auth()->id())->count();
        if ($applicationsCount >= 3) {
            return redirect('/application/create')->with('error', 'You can only apply for up to 3 projects.');
        }

        $application = new Application();
    
        $application->justification = $request->justification;
        $application->projectID = $request->project;
        $application->studentID = auth()->id();
    
        $application->save();
    
        return redirect("/u");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
}
