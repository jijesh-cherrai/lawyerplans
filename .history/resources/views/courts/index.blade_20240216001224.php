@extends('layouts.app')

@section('content')
    <!-- Your HTML code for listing courts here -->
    <h1 class="h3 mb-4 text-gray-800">List of Courts</h1>
    <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#createCourtModal">Create New Court</button>

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

    <!-- Create Court Modal -->
    <div class="modal fade" id="createCourtModal" tabindex="-1" role="dialog" aria-labelledby="createCourtModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createCourtModalLabel">Create New Court</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('courts.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="court_name">Court Name</label>
                            <input type="text" class="form-control" id="court_name" name="court_name" placeholder="Enter court name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Court Modal -->
    <div class="modal fade" id="editCourtModal" tabindex="-1" role="dialog" aria-labelledby="editCourtModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCourtModalLabel">Edit Court</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editCourtForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_court_name">Court Name</label>
                            <input type="text" class="form-control" id="edit_court_name" name="court_name" placeholder="Enter court name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // Initialize DataTable
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

            // Handle edit button click
            $(document).on('click', '.edit-court-btn', function () {
                var courtId = $(this).data('court-id');
                var courtName = $(this).data('court-name');

                $('#edit_court_name').val(courtName);
                $('#editCourtForm').attr('action', '/courts/' + courtId);
                $('#editCourtModal').modal('show');
            });
        });
    </script>
@endsection
