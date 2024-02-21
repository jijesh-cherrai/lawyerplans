@extends('layouts.app')

@section('content')
    <!-- Your HTML code for creating a new court here -->
    <h1 class="h3 mb-4 text-gray-800">Create New Court</h1>
    <form action="{{ route('courts.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="court_name">Court Name</label>
            <input type="text" class="form-control" id="court_name" name="court_name" placeholder="Enter court name">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
