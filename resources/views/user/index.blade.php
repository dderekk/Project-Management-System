@extends('layouts.master')

@section('title')
    HOME
@endsection

@section('heading')
    Home
@endsection

@section('intro')
    Shows a list of InP's names. Clicking on an InP will bring up the details page.
@endsection

@section('content')
    <div class="container">
        <div class="row mt-5">
            @foreach($InPs as $InP)
            <div class="col-4 mb-3 mt-5">
                <div class="card">
                    <div class="box">
                        <div class="content">
                            <h1><a href="{{ url("/u/$InP->id") }}">{{ $InP->name }}</a></h1>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    {{$InPs->links()}}
@endsection