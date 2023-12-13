<?php

namespace App\Http\Controllers;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class ProjectsController extends Controller
{   
    /**
     * A functionn to check trimester
     */
    private function availableTrimesters() {
        $currentMonth = Carbon::now()->month; // Get the current month using Carbon
        $trimesters = [1, 2, 3];
    
        if ($currentMonth > 3) {
            array_shift($trimesters); // Remove Trimester 1
        }
        if ($currentMonth > 7) {
            array_shift($trimesters); // Remove Trimester 2
        }
        if ($currentMonth > 11) {
            array_shift($trimesters); // Remove Trimester 3
        }
    
        return $trimesters;
    }

    /**
     * Middleware to check if it is inp
     */
    public function __construct()
    {
        // Apply the 'inp' middleware only to the 'create' and 'store' methods
        $this->middleware('inp')->only(['create', 'store']);
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
    public function create()
    {
        // Check if the logged-in user is of type 'InP' and is not approved
        if (!auth()->user()->is_approved) {
            return redirect()->back()->with('error', 'You are not approved to create a project.');
        }
        return view('project.create_form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        // Check if the logged-in user is of type 'InP' and is not approved
        if (!auth()->user()->is_approved) {
            return redirect()->back()->with('error', 'You are not approved to create a project.');
        }

        // NOTE: the resaon for not using 'regex' here is because it can not show the error automatically.
        // Remove spaces from title before validating
        $titleNoSpaces = str_replace(' ', '', $request->title);

        // Calculate word count of description
        $wordCount = str_word_count($request->description);

        // Modify the request data for validation
        $request->merge(['project title' => $titleNoSpaces, 'project description' => $wordCount]);

        $this->validate($request, [
            'project title' => 'required|min:6',
            'title' => [
                'required',
                Rule::unique('projects')->where(function ($query) use ($request) {
                    return $query->where('year', $request->year)
                                 ->where('trimester', $request->trimester);
                }),
            ],
            'project description' => 'required|min:3|integer',
            'team_size' => 'required|integer|between:3,6',
            'trimester' => ['required', 'integer',],
            'year' => 'required|integer',
            'coordinator_name' => 'required|min:6',
            'coordinator_email' => 'required|email'
        ]);

        if($request->year == Carbon::now()->year){
            $this->validate($request, ['trimester' => ['required', 'integer', Rule::in($this->availableTrimesters())]]);
        }
    
        $project = new Project();
    
        $project->title = $request->title;
        $project->description = $request->description;
        $project->team_size = $request->team_size;
        $project->trimester = $request->trimester;
        $project->year = $request->year;
        $project->inpID = auth()->id();
        $project->complexity = $request->complexity;

        $theEmail = $request->coordinator_name;
        $theName = $request->coordinator_email;
        $project->coordinator_email = $theEmail;
        $project->coordinator_name = $theName ;
    
        $project->save();
        Session::put('createProject', $project->id);
        return redirect("file/create");
    }

    /**
     * Display the projects details by the projects id
     */
    public function show(string $id)
    {
        $projectDetail=Project::with('applications.users')->find($id);
        $inpDetail=Project::find($id)->users;
        $applicated=Project::find($id)->applications;
        $files=Project::find($id)->projectFiles;
        $assignedStudents = User::where('type', 'Student')->where('assigned_project_id', $id)->with('profile')->get();
        return view('project.projectDetails')->with('projectDetail',$projectDetail)->with('inpDetail',$inpDetail)->with('applicated',$applicated)->with('files',$files)->with('assignedStudents',$assignedStudents);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $projectEdit = Project::find($id);
        return view('project.edit_form')->with('projectEdit',$projectEdit);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $titleNoSpaces = str_replace(' ', '', $request->title);

        // Calculate word count of description
        $wordCount = str_word_count($request->description);

        // Modify the request data for validation
        $request->merge(['project title' => $titleNoSpaces, 'project description' => $wordCount]);

        $this->validate($request, [
            'project title' => 'required|min:6',
            'project description' => 'required|min:3|integer',
            'team_size' => 'required|integer|between:3,6',
            'trimester' => ['required', 'integer'],
            'year' => 'required|integer',
            'coordinator_name' => 'required|min:6',
            'coordinator_email' => 'required|email'
        ]);

        if($request->year == Carbon::now()->year){
            $this->validate($request, ['trimester' => ['required', 'integer', Rule::in($this->availableTrimesters())]]);
        }

        $project = Project::find($id);
        $project->title = $request->title;
        $project->description = $request->description;
        $project->team_size = $request->team_size;
        $project->trimester = $request->trimester;
        $project->year = $request->year;
        $project->coordinator_name = $request->coordinator_name;
        $project->coordinator_email = $request->coordinator_email;
        $project->complexity = $request->complexity;
    
        $project->save();
        return redirect("project/$project->id");

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $project = Project::find($id);

        // Check if the project has any associated applications
        if ($project->applications->count() > 0) {
            // Redirect to the project's details page with an error message
            return redirect("project/$id")->with('error', 'This project has students applied to it and cannot be deleted.');
        }

        $project->delete();
        return redirect("/u");
    }
}
