@extends('layouts.master')
@section('title')
    Project Create
@endsection

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Files Upload Form</div>
                <div class="card-body">
                    <form method="POST" action='{{url("/file")}}' enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label>Name: </label>
                            <input type="text" class="form-control" name="name" placeholder="Enter file name" value="{{old('name')}}">
                        </div>
                        <div class="form-group">
                            <label>File: </label>
                            <input type="file" class="form-control" name="file" require>
                        </div>
                        <button type="submit" name="submitType" value="Next" class="btn btn-info">Upload and Add More</button>
                        <button type="submit" name="submitType" value="Finish" class="btn btn-success">Finish and View Details</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
