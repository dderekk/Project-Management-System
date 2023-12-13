@extends('layouts.master')
@section('title')
    Project Edit
@endsection

@section('heading')
    Update Project
@endsection

@section('intro')
    Only the Owner can Update Project
@endsection

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Project Update Form </div>
                    <div class="card-body">
                        <form method="POST" action='{{url("/project/$projectEdit->id")}}'>
                            {{csrf_field()}}
                            {{method_field('PUT')}}
                            <div class="form-group">
                                <label>Organiser Name: </label>
                                <p><stong>{{Auth::user()->name}}</stong></p>
                            </div>
                            <div class="form-group">
                                <label>Organiser Email: </label>
                                <p><stong>{{Auth::user()->email}}</stong></p>
                            </div>
                            <div class="form-group"><label>Title: </label><input type="text" name="title" class="form-control" value = "{{$projectEdit->title}}"></div>
                            <div class="form-group"><label>Coordinator (Industry Partner) Name: </label><input type="text" name="coordinator_name" class="form-control" value = "{{$projectEdit->coordinator_name}}"></div>
                            <div class="form-group"><label>Coordinator (Industry Partner) Email: </label><input type="text" name="coordinator_email" class="form-control" value = "{{$projectEdit->coordinator_email}}"></div>
                            <div class="form-group"><label>Description</label><textarea type="text" rows="5" name="description" class="form-control" value = "{{$projectEdit->description}}">{{$projectEdit->description}}</textarea></div>
                            @if(count($errors)>0)
                            <div class = "alert">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <p>
                                <label>Offering Year: </label>
                                <select name="year">
                                    @for($i = 0; $i < 20; $i++)
                                        <option value="{{ \Carbon\Carbon::now()->addYears($i)->year }}" {{ $projectEdit->year == \Carbon\Carbon::now()->addYears($i)->year ? 'selected' : '' }}>{{ \Carbon\Carbon::now()->addYears($i)->year }}</option>
                                    @endfor
                                </select>
                            </p>
                            <p>
                                <label>Offering Trimester: </label>
                                <select name="trimester">
                                    @foreach(range(1, 3) as $trimester)
                                        <!-- i am using ternary here, to make the code simpler-->
                                        <option value="{{ $trimester }}" {{ $projectEdit->trimester == $trimester ? 'selected' : '' }}>{{ $trimester }}</option>
                                    @endforeach
                                </select>
                            </p>
                            <p>
                                <label>Team Size: </label>
                                <select name="team_size">
                                    @foreach(range(3, 6) as $team_size)
                                        <option value="{{ $team_size }}" {{ $projectEdit->team_size == $team_size ? 'selected' : '' }}>{{ $team_size }}</option>
                                    @endforeach
                                </select>
                            </p>
                            <p>
                                <label>Complexity: </label>
                                <select name="complexity">
                                    <option value="easy" {{ $projectEdit->complexity == 'easy' ? 'selected' : '' }}>Easy</option>
                                    <option value="moderate" {{ $projectEdit->complexity == 'moderate' ? 'selected' : '' }}>Moderate</option>
                                    <option value="hard" {{ $projectEdit->complexity == 'hard' ? 'selected' : '' }}>Hard</option>
                                </select>
                            </p>
                            <input type="submit" value="Update" class="btn btn-info">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection