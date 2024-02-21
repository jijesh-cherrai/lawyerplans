@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
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
<div class="modal fade" id="courtModal" tabindex="-1" role="dialog" aria-labelledby="courtModalLabel" aria-hidden="true">
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
                        <input type="text" class="form-control" id="court_name" name="court_name" placeholder="Enter court name">
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // DataTable initialization
        $('#courts-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("courts.get") }}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'court_name', name: 'court_name' },
                { data: 'created_at', name: 'created_at' },
                { data: 'updated_at', name: 'updated_at' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ]
        });

        // Show create/edit modal on button click
        $('#createCourtButton').click(function() {
            $('#courtModal').modal('show');
            $('#courtModalLabel').text('Create New Court');
            $('#courtForm').attr('action', '{{ route("courts.store") }}');
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
    });
</script>
@endsection
