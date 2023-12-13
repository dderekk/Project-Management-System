@extends('layouts.master')

@section('title')
    Student Profiles List
@endsection

@section('heading')
    All Profiles
@endsection

@section('intro')
    List of all student profiles.
@endsection

@section('content')
<div class="container mt-4">
    <form action="{{ route('users.autoAssign') }}" method="GET" class="mb-4">
        @csrf
        <button type="submit" class="btn btn-primary">Auto Assign</button>
    </form>
    <div class="row">
        @foreach($allProfiles as $profile)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ $profile->users->name }}</h5>
                        <p class="card-text"><strong>Email:</strong> {{ $profile->users->email }}</p>
                        <p class="card-text"><strong>GPA:</strong> {{ $profile->GPA }}</p>
                        <h6>Roles and Preferences:</h6>
                        <ul class="list-group list-group-flush">
                        @foreach($profile->getAttributes() as $key => $value)
                            @if(in_array($key, ['softwareDeveloper', 'projectManager', 'businessAnalyst', 'tester', 'clientLiaison']) && $value == true)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ ucfirst(str_replace(['softwareDeveloper', 'projectManager', 'businessAnalyst', 'tester', 'clientLiaison'], ['Software Developer', 'Project Manager', 'Business Analyst', 'Tester', 'Client Liaison'], $key)) }}
                                    <span class="badge badge-primary badge-pill">{{ $value }}</span>
                                </li>
                            @endif
                        @endforeach
                        </ul>
                    </div>
                    <div class="card-footer">
                        <form method="GET" action="{{ url('/profile/show/' . $profile->users->id) }}">
                            <button class="btn btn-info btn-block">View Profile</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>    
</div>
@endsection
