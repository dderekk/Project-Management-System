@extends('layouts.master')

@section('title')
    Project List
@endsection

@section('heading')
    Profile
@endsection

@section('intro')
    create and edit profile
@endsection

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3>Create Your Own Profile</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action='{{url("/profile")}}'>
                            {{csrf_field()}}
                            {{method_field('PUT')}}
                            <div class="form-group">
                                <label><strong>Your Name:</strong></label>
                                <input type="text" class="form-control" name="name" value="{{Auth::user()->name}}" disabled>
                            </div>
                            <div class="form-group">
                                <label><strong>Your Email:</strong></label>
                                <input type="text" class="form-control" name="email" value="{{Auth::user()->email}}" disabled>
                            </div>
                            <div class="form-group">
                                <label><strong>GPA:</strong></label>
                                <select class="form-control" name="gpa">
                                    @foreach(range(0, 7) as $gpa)
                                        <option value="{{ $gpa }}" {{ (old('gpa') ?? ($profile ? $profile->GPA : 0)) == $gpa ? 'selected' : '' }}>{{ $gpa }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label><strong>Expected Graduation Year:</strong></label>
                                <select class="form-control" name="graduation_year">
                                    @for($year = date('Y'); $year <= date('Y') + 8; $year++)
                                        <option value="{{ $year }}" {{ (old('graduation_year') ?? ($profile ? $profile->graduation_year : date('Y'))) == $year ? 'selected' : '' }}>{{ $year }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="form-group">
                                <label><strong>Expected Graduation Trimester:</strong></label>
                                <select class="form-control" name="graduation_trimester">
                                    @foreach([1, 2, 3] as $trimester)
                                        <option value="{{ $trimester }}" {{ (old('graduation_trimester') ?? ($profile ? $profile->graduation_trimester : '')) == $trimester ? 'selected' : '' }}>{{ $trimester }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>
                                    <strong>
                                        Roles Preference: 
                                        <span class="text-muted d-block mb-2">(0-5, 0 being <span class="text-warning">not good at</span>, 5 being the <span class="text-success">highest preference</span>)</span>
                                    </strong>
                                </label><br>
                                @foreach(['softwareDeveloper' => 'Software Developer', 'projectManager' => 'Project Manager', 'businessAnalyst' => 'Business Analyst', 'tester' => 'Tester', 'clientLiaison' => 'Client Liaison'] as $key => $role)
                                    <label>{{ $role }}: </label>
                                    <select class="form-control mb-2" name="roles[{{ $key }}]">
                                        @foreach(range(0, 5) as $preference)
                                            <option value="{{ $preference }}" {{ (old('roles.'.$key) ?? ($profile ? $profile->$key : 0)) == $preference ? 'selected' : '' }}>{{ $preference }}</option>
                                        @endforeach
                                    </select>
                                @endforeach
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" name="Save" class="btn btn-info">Save Profile</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
