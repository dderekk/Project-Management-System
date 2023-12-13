@extends('layouts.master')

@section('title')
    IndustryPartner Details
@endsection

@section('heading')
    {{$usersDetails->name}} Detail
@endsection

@section('intro')
    shows {{$usersDetails->name}}'s details
@endsection

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h4>{{$usersDetails->name}}</h4>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Name:</strong> {{$usersDetails->name}}</li>
                    <li class="list-group-item"><strong>Email:</strong> {{$usersDetails->email}}</li>
                    <li class="list-group-item"><strong>Organization:</strong> {{$usersDetails->organization}}</li>
                </ul>
                @if(Auth::check() && Auth::user()->type === 'Teacher')
                    @if($usersDetails->is_approved == 1)
                        <button class="btn btn-success mt-3" disabled>Approved</button>
                    @else
                        <form action="{{ url("/approve-inp/$usersDetails->id") }}" method="POST" class="mt-3">
                            @csrf
                            <button type="submit" class="btn btn-primary">Approve</button>
                        </form>
                    @endif
                @endif
            </div>
        </div>

        <div class="card mt-5">
            <div class="card-header">
                <h4>Projects Offered</h4>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    @foreach($userproject as $project)
                        <li class="list-group-item"><a href="{{url("/project/$project->id")}}">{{$project->title}}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
