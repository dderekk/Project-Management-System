@extends('layouts.master')
@section('title')
    Project Create
@endsection

@section('heading')
    Create Project
@endsection

@section('intro')
    only Inp can Create a project
@endsection

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Project Create Form</div>
                <div class="card-body">
                    <form method="POST" action='{{url("/project")}}'>
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="name">Organiser(creater) Name:</label>
                            <p><input type="text" name="name" class="form-control" value = "{{Auth::user()->name}}" disabled></p>
                        </div>
                        <div class="form-group">
                            <label for="email">Organiser(creater) Email:</label>
                            <p><input type="text" name="email" class="form-control" value = "{{Auth::user()->email}}" disabled></p>
                        </div>
                        <div class="form-group">
                            <label for="coordinator_name">Industry Partner Name:</label>
                            <input type="text" class="form-control" id="coordinator_name" name="coordinator_name" value="{{old('coordinator_name')}}" placeholder="Enter Industry Partner Name">
                        </div>
                        <div class="form-group">
                            <label for="coordinator_email">Industry Partner Email:</label>
                            <input type="email" class="form-control" id="coordinator_email" name="coordinator_email" value="{{old('coordinator_email')}}" placeholder="Enter Industry Partner Email">
                        </div>
                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="text" class="form-control" id="title" name="title" value = "{{old('title')}}" placeholder="Enter project title">
                        </div>
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea class="form-control" id="description" rows="5" type="text" name="description" value = "{{old('description')}}" placeholder="Enter your project description">{{old('description')}}</textarea>
                        </div>
                        @if(count($errors)>0)
                            <div class = "alert">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="form-group">
                            <label>Offering Year: </label>
                            <select name="year">
                                @for($i = 0; $i < 20; $i++)
                                    <option value="{{ \Carbon\Carbon::now()->addYears($i)->year }}" {{ old('year') == \Carbon\Carbon::now()->addYears($i)->year ? 'selected' : '' }}>{{ \Carbon\Carbon::now()->addYears($i)->year }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Offering Trimester: </label>
                            <select name="trimester">
                                @foreach(range(1, 3) as $trimester)
                                    <!-- i am using ternary here, to make the code simpler-->
                                    <option value="{{ $trimester }}" {{ old('trimester') == $trimester ? 'selected' : '' }}>{{ $trimester }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Team Size: </label>
                            <select name="team_size">
                                @foreach(range(3, 6) as $team_size)
                                    <option value="{{ $team_size }}" {{ old('team_size') == $team_size ? 'selected' : '' }}>{{ $team_size }}</option>
                                @endforeach
                            </select>
                            <span>students</span>
                        </div>
                        <div class="form-group">
                            <label>Complexity: </label>
                            <select name="complexity">
                                <option value="easy" {{ old('complexity') == 'easy' ? 'selected' : '' }}>Easy</option>
                                <option value="moderate" {{ old('complexity') == 'moderate' ? 'selected' : '' }}>Moderate</option>
                                <option value="hard" {{ old('complexity') == 'hard' ? 'selected' : '' }}>Hard</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-info" value="Create">Upload Files</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection