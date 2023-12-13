@extends('layouts.master')

@section('title')
    Project List
@endsection

@section('heading')
    Project List
@endsection

@section('intro')
    Displays all projects (names) grouped by the year and trimester of offering.
@endsection

@section('content')
    <div class="container mt-5">

        @foreach($projects as $year => $projectsByYear)
            <div class="card mb-4">
                <div class="card-header">
                    Offering Year: {{ $year }}
                </div>
                <div class="card-body">
                    @foreach($projectsByYear as $trimester => $projectGroup)
                        <h4 class="mb-3">Trimester: {{ $trimester }}</h4>
                        <ul class="list-group mb-4">
                            @foreach($projectGroup as $project)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="{{url("/project/$project->id")}}" class="mr-2">{{ $project->title }}</a>
                                    <div class="d-flex justify-content-end align-items-center">
                                        <span class="badge badge-primary badge-pill mr-2">{{ $project->applications_count }}</span>
                                        <span class="badge badge-success badge-pill">{{ $project->assigned_students_count }}</span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endforeach
                </div>
            </div>
        @endforeach

    </div>
@endsection
