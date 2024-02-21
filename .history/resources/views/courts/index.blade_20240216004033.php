@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Courts</div>

                    <div class="card-body">
                        <!-- Create Court Button -->
                        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#createCourtModal">
                            Create New Court
                        </button>

                        <!-- Courts Table -->
                        <table id="courts-table" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Court Name</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Table rows will be loaded dynamically via AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Court Modal -->
    <div class="modal fade" id="createCourtModal" tabindex="-1" role="dialog" aria-labelledby="createCourtModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createCourtModalLabel">Create New Court</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Create Court Form -->
                    <form id="createCourtForm">
                        @csrf
                        <div class="form-group">
                            <label for="court_name">Court Name</label>
                            <input type="text" class="form-control" id="court_name" name="court_name"
                                placeholder="Enter court name">
                        </div>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Court Modal -->
    <div class="modal fade" id="editCourtModal" tabindex="-1" role="dialog" aria-labelledby="editCourtModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCourtModalLabel">Edit Court</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Edit Court Form -->
                    <form id="editCourtForm">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="edit_court_name">Court Name</label>
                            <input type="text" class="form-control" id="edit_court_name" name="court_name"
                                placeholder="Enter court name">
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // DataTable initialization
            var dataTable = $('#courts-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('courts.data') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'court_name',
                        name: 'court_name'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // AJAX for creating a court
            $('#createCourtForm').submit(function(event) {
                event.preventDefault(); // Prevent default form submission

                var formData = $(this).serialize(); // Serialize form data
                $.ajax({
                    url: '{{ route('courts.store') }}',
                    type: 'POST',
                    data: formData,
                    success: function(data) {
                        // Update DataTable with new court data
                        dataTable.ajax.reload();
                        $('#createCourtModal').modal('hide'); // Hide modal after success
                    },
                    error: function(xhr, status, error) {
                        // Handle errors
                    }
                });
            });

            // AJAX for editing a court
            $('#editCourtForm').submit(function(event) {
                event.preventDefault(); // Prevent default form submission

                var courtId = $(this).data('id'); // Get court ID from form data attribute
                var formData = $(this).serialize(); // Serialize form data
                $.ajax({
                    url: '/courts/' + courtId, // Adjust the URL as needed
                    type: 'PUT',
                    data: formData,
                    success: function(data) {
                        // Update DataTable with new court data
                        dataTable.ajax.reload();
                        $('#editCourtModal').modal('hide'); // Hide modal after success
                    },
                    error: function(xhr, status, error) {
                        // Handle errors
                    }
                });
            });
        });
    </script>
@endsection
