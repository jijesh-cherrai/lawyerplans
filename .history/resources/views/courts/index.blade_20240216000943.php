@extends('layouts.app')

@section('content')
    <!-- Your HTML code for listing courts here -->
    <h1 class="h3 mb-4 text-gray-800">List of Courts</h1>
    <a href="{{ route('courts.create') }}" class="btn btn-success mb-3">Create New Court</a>

    <!-- DataTable -->
    <table id="courts-table" class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Court Name</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Actions</th>
            </tr>
        </thead>
    </table>

    <script>
        $(document).ready(function () {
            $('#courts-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '/courts',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'court_name', name: 'court_name' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'updated_at', name: 'updated_at' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false },
                ]
            });
        });
    </script>
@endsection
