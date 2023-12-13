<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectFiles;
use Illuminate\Support\Facades\Session;

class ProjectFileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating new file uploading form
     */
    public function create()
    {
        return view('projectFiles.create_form');
    }

    /**
     * the function get the data from the files submit form
     * check the file is either image or pdf
     * stock it in storage
     */
    public function store(Request $request)
    {   
        $projectID = Session::get('createProject');
        if($request->input('submitType') == 'Finish' && (!$request->hasFile('file')||!$request->name)){
            if(!$request->hasFile('file')){
                return redirect("project/$projectID");
            }elseif(!$request->name && $request->hasFile('file')){
                return back()->with('error', 'Please Enter the Name.');
            }
        }

        $request->validate([
            'file' => 'required|file|mimes:jpeg,png,jpg,gif,pdf',
        ]);
        

        if ($request->hasFile('file')) {
            $image_store = $request->file('file')->store('products_images', 'public');
            if(!$request->name){
                return back()->with('error', 'Please Enter the Name.');
            }
        } else {
            // Handle the error, maybe return a response to inform the user
            if($request->input('submitType') == 'Next') {
                return back()->with('error', 'File not uploaded.');
            } elseif($request->input('submitType') == 'Finish') {
                return redirect("project/$projectID");
            }
        }
        
        $projectFile = new ProjectFiles;

        $projectFile->name = $request->name;

        // Get the file extension
        $extension = strtolower(request()->file('file')->getClientOriginalExtension());

        // Determine the type based on the extension, either be image or pdf
        if (in_array($extension, ['jpeg', 'png', 'jpg', 'gif'])) {
            $projectFile->type = 'image';
        } elseif ($extension == 'pdf') {
            $projectFile->type = 'pdf';
        } else {
            // Handle other file types or set a default type if needed
            $projectFile->type = 'other';
        }

        $projectFile->file_path = $image_store;
        $projectID = Session::get('createProject');
        $projectFile->project_id = $projectID;

        $projectFile->save();
        if($request->input('submitType') == 'Next') {
            return redirect("file/create");
        } elseif($request->input('submitType') == 'Finish') {
            return redirect("project/$projectID");
        }
        
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
