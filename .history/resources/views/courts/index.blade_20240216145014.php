@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Courts</div>

                    <div class="card-body">
                        <!-- Create Court Button -->
                        <button type="button" class="btn btn-primary btn-sm mb-3" id="createCourtButton">
                            <i class="fa fa-plus"></i> Add Court
                        </button>

                        <!-- Courts Table -->
                        <table id="courts-table" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Court Name</th>
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
                    <form id="courtForm" method="POST">
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
    <div class="modal fade" id="editCourtModal" tabindex="-1" role="dialog" aria-labelledby="editCourtModalLabel" aria-hidden="true">
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
                    <form id="editCourtForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="edit_court_name">Court Name</label>
                            <input type="text" class="form-control" id="edit_court_name" name="court_name" placeholder="Enter court name">
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
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
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // Show create modal on button click
            $('#createCourtButton').click(function() {
                $('#courtModal').modal('show');
                $('#courtForm').attr('action', '{{ route('courts.store') }}');
                $('#court_name').val('');
            });

            // Handle form submission for create
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

            // Show edit modal on button click
            $('#courts-table').on('click', '.editCourtButton', function() {
                var courtId = $(this).data('id');
                var courtName = $(this).data('court_name');
                $('#editCourtModal').modal('show');
                $('#edit_court_name').val(courtName);
                var editUrl = "{{route('courts.update',['court'=>'__id__'])}}";
                editUrl = editUrl.replace("__id__",courtId)
                $('#editCourtForm').attr('action', editUrl);
            });

            // Handle form submission for edit
            $('#editCourtForm').submit(function(event) {
                event.preventDefault();
                var formData = $(this).serialize();
                var action = $(this).attr('action');

                $.ajax({
                    url: action,
                    method: 'PUT',
                    data: formData,
                    success: function(response) {
                        $('#courts-table').DataTable().ajax.reload();
                        $('#editCourtModal').modal('hide');
                        toastr.success(response.message);
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON.errors.court_name[0]);
                    }
                });
            });
        });
    </script>
@endsection
