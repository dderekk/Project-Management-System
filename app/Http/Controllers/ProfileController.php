<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Profile;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */

    public function __construct()
    {
         // Middleware to ensure only students or teachers can access 'show', 'edit', and 'update' methods
        $this->middleware('studentOrTeacher')->only(['show']);

        $this->middleware('Student')->only(['edit', 'update']);
        
        // Apply ensureProfileCreated middleware only for students on 'show' method
        $this->middleware('ensureProfileCreated')->only(['show']);
        
    }

    public function index()
     {

        $allProfiles = Profile::with('users')->get();
        return view('profile.index')->with('allProfiles',$allProfiles);
     }

    public function show(string $id)
     {
        if(Auth::user()->type=='Student'){
            $profileDetail=Profile::where('studentID', $id)->with('users')->first();
        }elseif(Auth::user()->type=='Teacher'){
            $profileDetail=Profile::where('studentID', $id)->with('users')->first();
        }else{
            return redirect()->back()->with('error', 'You are not able access');
        }
        return view('profile.profileDetails')->with('profileDetail',$profileDetail);
     }

    public function edit(Request $request): View
    {
        $profile = Profile::where('studentID', Auth::user()->id)->first();
            
        return view('profile.edit', [
            'user' => $request->user(),
            'profile' => $profile
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Update the user's email if it has changed
        //$request->user()->fill($request->validated());

        //if ($request->user()->isDirty('email')) {
        //    $request->user()->email_verified_at = null;
        //}

        //$request->user()->save();
        // Check if all roles are set to 0
        $allRolesZero = true;
        foreach ($request->roles as $roleValue) {
            if ($roleValue != 0) {
                $allRolesZero = false;
                break;
            }
        }

        if ($allRolesZero) {
            return Redirect::route('profile.edit')->with('error', 'Please select at least one role with a preference greater than 0.');
        }
        $selectedRoles = array_filter($request->roles); // remove the 0 selection
    
        if (empty($selectedRoles)) {
            return Redirect::route('profile.edit')->with('error', 'Please select at least one role.');
        }

        // Retrieve the user's profile
        // Retrieve the user's profile or create a new one if it doesn't exist
        $profile = Profile::firstOrCreate(
            ['studentID' => Auth::user()->id],
            [
                'GPA' => $request->gpa,
                'graduation_year' => $request->graduation_year,
                'graduation_trimester' => $request->graduation_trimester,
                'softwareDeveloper' => $request->roles['softwareDeveloper'] ?? 0,
                'projectManager' => $request->roles['projectManager'] ?? 0,
                'businessAnalyst' => $request->roles['businessAnalyst'] ?? 0,
                'tester' => $request->roles['tester'] ?? 0,
                'clientLiaison' => $request->roles['clientLiaison'] ?? 0,
            ]
        );

        // If the profile already exists, update it with the new data
        if (!$profile->wasRecentlyCreated) {
            $profile->GPA = $request->gpa;
            $profile->softwareDeveloper = $request->roles['softwareDeveloper'] ?? 0;
            $profile->projectManager = $request->roles['projectManager'] ?? 0;
            $profile->businessAnalyst = $request->roles['businessAnalyst'] ?? 0;
            $profile->tester = $request->roles['tester'] ?? 0;
            $profile->clientLiaison = $request->roles['clientLiaison'] ?? 0;
            $profile->graduation_year = $request->graduation_year;
            $profile->graduation_trimester = $request->graduation_trimester;
            $saved = $profile->save();
        }

        return Redirect::route('profile.show', ['id' => Auth::user()->id])->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
