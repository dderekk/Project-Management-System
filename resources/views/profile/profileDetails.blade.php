@extends('layouts.master')

@section('title')
    Profile Details
@endsection

@section('heading')
    Profile
@endsection

@section('intro')
    show profile details
@endsection

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3>Profile Details</h3>
                    </div>
                    <div class="card-body">
                        <form method="get" action='{{url("/profile")}}'>
                            {{csrf_field()}}
                            <div class="form-group">
                                <label><strong>Name:</strong></label>
                                <p>{{$profileDetail->users->name}}</p>
                            </div>
                            <div class="form-group">
                                <label><strong>Email:</strong></label>
                                <p>{{$profileDetail->users->email}}</p>
                            </div>
                            <div class="form-group">
                                <label><strong>GPA:</strong></label>
                                <p>{{$profileDetail->GPA}}</p>
                            </div>
                            <div class="form-group">
                                <label><strong>Expected Graduation:</strong></label>
                                <p>Year: {{$profileDetail->graduation_year}} | Trimester: {{$profileDetail->graduation_trimester}}</p>
                            </div>
                            <div class="form-group">
                                <label><strong>Roles:</strong></label>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Role</th>
                                            <th>Preference</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($profileDetail->getAttributes() as $key => $value)
                                            @if(in_array($key, ['softwareDeveloper', 'projectManager', 'businessAnalyst', 'tester', 'clientLiaison']) && $value == true)
                                                <tr>
                                                    <td>
                                                        {{ ucfirst(str_replace(['softwareDeveloper', 'projectManager', 'businessAnalyst', 'tester', 'clientLiaison'], ['Software Developer', 'Project Manager', 'Business Analyst', 'Tester', 'Client Liaison'], $key)) }}
                                                    </td>
                                                    <td>
                                                        {{$value}}
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if(Auth::check() && Auth::user()->type === 'Student')
                                <div class="form-group text-center">
                                    <button type="submit" name="Edit" class="btn btn-info">Edit Profile</button>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
