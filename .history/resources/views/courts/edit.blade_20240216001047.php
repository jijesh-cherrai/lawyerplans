@extends('layouts.app')

@section('content')
    <!-- Your HTML code for editing the court here -->
    <h1 class="h3 mb-4 text-gray-800">Edit Court</h1>
    <form action="{{ route('courts.update', $court->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="court_name">Court Name</label>
            <input type="text" class="form-control" id="court_name" name="court_name" value="{{ $court->court_name }}">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection
