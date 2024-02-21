@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Courts</div>

                    <div class="card-body">
                        <!-- Create Court Button -->
                        <button type="button" class="btn btn-primary mb-3" id="createCourtButton">
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
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create/Edit Court Modal -->
    <div class="modal fade" id="courtModal" tabindex="-1" role="dialog" aria-labelledby="courtModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="courtModalLabel">Create New Court</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form for creating/editing a court -->
                    <form id="courtForm">
                        @csrf
                        <div class="form-group">
                            <label for="court_name">Court Name</label>
                            <input type="text" class="form-control" id="court_name" name="court_name"
                                placeholder="Enter court name">
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
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
                    <!-- Form for editing a court -->
                    <form id="editCourtForm">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="edit_court_name">Court Name</label>
                            <input type="text" class="form-control" id="edit_court_name" name="court_name"
                                placeholder="Enter court name">
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Court Modal -->
    <div class="modal fade" id="deleteCourtModal" tabindex="-1" role="dialog" aria-labelledby="deleteCourtModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteCourtModalLabel">Delete Court</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this court?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <form id="deleteCourtForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            // DataTable initialization
            $('#courts-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('courts.get') }}',
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

            // Show create/edit modal on button click
            $('#createCourtButton').click(function() {
                $('#courtModal').modal('show');
                $('#courtModalLabel').text('Create New Court');
                $('#courtForm').attr('action', '{{ route('courts.store') }}');
                $('#court_name').val('');
            });

            // Handle form submission for create/edit
            $('#courtForm').submit(function(event) {
                event.preventDefault();
                var formData = $(this).serialize();
                var action = $(this).attr('action');
                $.ajax({
                    url: action,
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#courts-table').DataTable().ajax.reload();
                        $('#courtModal').modal('hide');
                        toastr.success(response.message);
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON.errors.court_name[0]);
                    }
                });
            });

            // Handle click event for edit button
            $(document).on('click', '.editCourtButton', function() {
                var courtId = $(this).data('id');
                var courtName = $(this).data('court-name');

                // Populate edit modal with court details
                $('#edit_court_name').val(courtName);
                $('#editCourtModal').modal('show');

                // Update form action URL with court ID
                var editUrl = '{{ route('courts.update', ':id') }}';
                editUrl = editUrl.replace(':id', courtId);
                $('#editCourtForm').attr('action', editUrl);
            });

            // Handle click event for delete button
            $(document).on('click', '.deleteCourtButton', function() {
                var courtId = $(this).data('id');
                var deleteUrl = '{{ route('courts.destroy', ':id') }}';
                deleteUrl = deleteUrl.replace(':id', courtId);
                $('#deleteCourtForm').attr('action', deleteUrl);
                $('#deleteCourtModal').modal('show');
            });
        });
    </script>
@endsection
