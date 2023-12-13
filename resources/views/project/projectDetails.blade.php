@extends('layouts.master')

@section('title')
    Project Details
@endsection

@section('heading')
    Project Details
@endsection

@section('intro')
    shows the details about "{{$projectDetail->title}}"
@endsection

@section('content')
    <div class="container mt-5">

        <!-- Project Actions for Industry Partner -->
        @if(Auth::check() && Auth::user()->type === 'Industry Partner' && Auth::user()->name === $inpDetail->name)
            <div class="mb-4">
                <form method="get" action="{{url("project/$projectDetail->id/edit")}}" style="display: inline-block;">
                    @csrf  
                    <button class="btn btn-warning" type="submit">Edit Project</button>
                </form> 

                <form method="post" action="{{url("project/$projectDetail->id")}}" style="display: inline-block;">
                    @csrf
                    {{method_field('DELETE')}}  
                    <button class="btn btn-danger" type="submit">Delete</button>
                </form>
            </div>
        @elseif(Auth::check() && Auth::user()->type === 'Student')
            <div class="mb-4">
                <form method="get" action="{{url('/application/create?project_id=' . $projectDetail->id)}}" style="display: inline-block;">
                    @csrf  
                    <input type="hidden" name="project_id" value="{{$projectDetail->id}}">
                    <button class="btn btn-warning" type="submit">Apply This Project</button>
                </form>
            </div>
        @endif

        <!-- Project Details -->
        <div class="card mb-4">
            <div class="card-header">
                Project Details
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Organiser(creater) Name:</strong> {{$inpDetail->name}}</li>
                    <li class="list-group-item"><strong>Organiser(creater) Email:</strong> {{$inpDetail->email}}</li>
                    <li class="list-group-item"><strong>Industry Partner Name:</strong> {{$projectDetail->coordinator_name}}</li>
                    <li class="list-group-item"><strong>Industry Partner Email:</strong> {{$projectDetail->coordinator_email}}</li>
                    <li class="list-group-item"><strong>Offering:</strong> in trimester {{$projectDetail->trimester}} year {{$projectDetail->year}}</li>
                    <li class="list-group-item"><strong>Title:</strong> {{$projectDetail->title}}</li>
                    <li class="list-group-item"><strong>Description:</strong> {{$projectDetail->description}}</li>
                    <li class="list-group-item"><strong>Team Size:</strong> {{$projectDetail->team_size}} Students</li>
                    <li class="list-group-item"><strong>Complexity:</strong> {{$projectDetail->complexity}}</li>
                </ul>
            </div>
        </div>

        <!-- Files -->
        <div class="card mb-4">
            <div class="card-header">
                Files
            </div>
            <div class="card-body">
                @foreach($files as $file)
                    @if($file->type == 'image')
                        <img src="{{url($file->file_path)}}" alt="file image" class="img-fluid mb-3" style="max-width:300px;">
                    @elseif($file->type == 'pdf')
                        <a href="{{url($file->file_path)}}" download class="btn btn-primary mb-3">Download PDF: {{$file->name}}</a><br>
                    @endif
                @endforeach
            </div>
        </div>

        <!-- Applications -->
        @if(count($applicated) > 0)
            <div class="card mb-4">
                <div class="card-header">
                    Applications
                </div>
                <div class="card-body">
                    @foreach($applicated as $application)
                        <div class="mb-3">
                            <strong>{{ $application->users->name }}</strong>
                            <p>{{ $application->justification }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Assigned Students -->
        <div class="card">
            <div class="card-header">
                Assigned Students
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($assignedStudents as $profile)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $profile->name }}</h5>
                                    <p class="card-text"><strong>Email:</strong> {{ $profile->email }}</p>
                                    <p class="card-text"><strong>GPA:</strong> {{ $profile->profile->GPA }}</p>
                                    <h6>Roles and Preferences:</h6>
                                    <ul class="list-group list-group-flush">
                                    @foreach($profile->profile->getAttributes() as $key => $value)
                                        @if(in_array($key, ['softwareDeveloper', 'projectManager', 'businessAnalyst', 'tester', 'clientLiaison']) && $value == true)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                {{ ucfirst(str_replace(['softwareDeveloper', 'projectManager', 'businessAnalyst', 'tester', 'clientLiaison'], ['Software Developer', 'Project Manager', 'Business Analyst', 'Tester', 'Client Liaison'], $key)) }}
                                                <span class="badge badge-primary badge-pill">{{ $value }}</span>
                                            </li>
                                        @endif
                                    @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>    
            </div>
        </div>

    </div>
@endsection
