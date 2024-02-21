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
                        <input type="hidden" id="method" name="_method" value="POST">
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
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            // DataTable initialization
            var table = $('#courts-table').DataTable({
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
                        data: null,
                        render: function(data) {
                            return '<button type="button" class="btn btn-primary btn-sm editCourtButton" data-id="' +
                                data.id + '">Edit</button>' +
                                '<button type="button" class="btn btn-danger btn-sm deleteCourtButton" data-id="' +
                                data.id + '">Delete</button>';
                        }
                    }
                ]
            });

            // Show create/edit modal on button click
            $('#createCourtButton').click(function() {
                $('#courtModal').modal('show');
                $('#courtModalLabel').text('Create New Court');
                $('#courtForm').attr('action', '{{ route('courts.store') }}');
                $('#method').val('POST');
                $('#court_name').val('');
            });

            // Handle form submission for create/edit
            $('#courtForm').submit(function(event) {
                event.preventDefault();
                var formData = $(this).serialize();
                var action = $(this).attr('action');
                $.ajax({
                    url: action,
                    method: $('#method').val(),
                    data: formData,
                    success: function(response) {
                        table.ajax.reload();
                        $('#courtModal').modal('hide');
                        toastr.success(response.message);
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON.errors.court_name[0]);
                    }
                });
            });

            // Show delete confirmation popup on delete button click
            $(document).on('click', '.deleteCourtButton', function() {
                var courtId = $(this).data('id');
                if (confirm('Are you sure you want to delete this court?')) {
                    $.ajax({
                        url: '{{ url('courts') }}/' + courtId,
                        method: 'DELETE',
                        success: function(response) {
                            table.ajax.reload();
                            toastr.success(response.message);
                        },
                        error: function(xhr) {
                            toastr.error(xhr.responseJSON.message);
                        }
                    });
                }
            });
        });
    </script>
@endsection
