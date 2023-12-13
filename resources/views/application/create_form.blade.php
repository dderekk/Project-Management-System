@extends('layouts.master')
@section('title')
    Apply Project
@endsection

@section('heading')
    Project Application
@endsection

@section('intro')
    students can chose and apply for projects
@endsection

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-20">
            <div class="card">
                <div class="card-header">Project Application Form</div>
                <div class="card-body">
                    <form method="POST" action='{{url("/application")}}'>
                        {{csrf_field()}}
                        <div class="form-group"><label>Your Name: </label><input type="text" class="form-control" name="name" value = "{{Auth::user()->name}}" disabled></div>
                        <div class="form-group"><label>Your Email: </label><input type="text" class="form-control" name="email" value = "{{Auth::user()->email}}" disabled></div>
                        <div class="form-group">
                            <label>Chose Project: </label>
                            <select name="project" class="form-control">
                                @foreach($allProjects as $project)
                                    <!-- i am using ternary here, to make the code simpler-->
                                    <option value="{{ $project->id }}" {{ $project_id == $project->id ? 'selected' : '' }}>
                                        <table>
                                            <tr>
                                                <th>[{{ $project->title }}]</th>
                                                <th> Tri: {{$project->trimester}}</th>
                                                <th> Year: {{$project->year}}</th>
                                            </tr>
                                        </table>
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Justification: </label>
                            <textarea type="text" class="form-control" rows="5" name="justification" required>{{old('justification')}}</textarea>
                        </div>
                        <button type="submit" class="btn btn-outline-primary btn-lg"" name="Apply">Apply This Project</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
        
        @if($error)
            <div class = "alert">
                <ul>
                    <li>{{$error}}</li>
                </ul>
            </div>
        @endif
</div>
@endsection