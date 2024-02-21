@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Case Diaries</div>

                    <div class="card-body">
                        <!-- Create Case Diary Button -->
                        <button type="button" class="btn btn-primary btn-sm mb-3" id="createCaseDiaryButton">
                            <i class="fa fa-plus"></i> Case Diary
                        </button>

                        <!-- Case Diaries Table -->
                        <table id="caseDiaries-table" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Case Number</th>
                                    <th>Court</th>
                                    <th>Party Names</th>
                                    <th>Case Date</th>
                                    <th>Purpose</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create/Edit Case Diary Modal -->
    <div class="modal fade" id="caseDiaryModal" tabindex="-1" role="dialog" aria-labelledby="caseDiaryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="caseDiaryModalLabel">Create New Case Diary</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form for creating/editing a case diary -->
                    <form id="caseDiaryForm" autocomplete="off">
                        @csrf
                        <input type="hidden" name="_method" id="method" value="POST">
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="case_number">Case Number</label>
                                <input type="text" class="form-control" id="case_number" name="case_number" autofocus="" placeholder="Enter case number">
                            </div>
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="court_id">Court</label>
                                <select class="form-control" id="court_id" name="court_id">
                                    <!-- Option for 'Select Court' -->
                                    <option value="">Select Court</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="party_names">Party names</label>
                                    <textarea class="form-control" id="party_names" name="party_names" placeholder="Enter Party names"></textarea>
                                </div>

                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="case_date">Case Date</label>
                                <input type="date" class="form-control" id="case_date" name="case_date">
                            </div>
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="purpose">Purpose</label>
                                <input type="text" class="form-control" id="purpose" name="purpose"
                                    placeholder="Enter Purpose">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" id="saveButton">Save</button>
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
            $('#caseDiaries-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('case-diaries.get') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'case_number',
                        name: 'case_number'
                    },
                    {
                        data: 'court.court_name',
                        name: 'court.court_name'
                    },
                    {
                        data: 'party_names',
                        name: 'party_names'
                    },
                    {
                        data: 'case_date',
                        name: 'case_date'
                    },
                    {
                        data: 'purpose',
                        name: 'purpose'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            // Show create/edit modal on button click
            $('#createCaseDiaryButton').click(function() {
                $('#caseDiaryModal').modal('show');
                $('#caseDiaryModalLabel').text('Create New Case Diary');
                $('#caseDiaryForm').attr('action', '{{ route('case-diaries.store') }}');
                $('#case_number').val('');
                $('#case_number').focus();
                $('#court_id').val('');
                $('#party_names').val('');
                $('#case_date').val('');
                $('#purpose').val('');

                // Fetch courts data dynamically
                $.ajax({
                    url: '{{ route('courts.all') }}',
                    type: 'GET',
                    success: function(response) {
                        // Clear existing options
                        $('#court_id').empty().html(`<option value="">Select Court</option>`);
                        // Append fetched court options
                        $.each(response, function(key, value) {
                            $('#court_id').append(`<option value="${value.id}">${value.court_name}</option>`);
                        });
                    },
                    error: function(xhr) {
                        console.log('Error fetching courts:', xhr);
                    }
                });
            });

            // Handle form submission for create/edit
            $('#caseDiaryForm').submit(function(event) {
                event.preventDefault();
                var formData = $(this).serialize();
                var action = $('#caseDiaryForm').attr('action');
                var method = $('#method').val();

                $.ajax({
                    url: action,
                    method: method,
                    data: formData,
                    success: function(response) {
                        $('#caseDiaries-table').DataTable().ajax.reload();
                        $('#caseDiaryModal').modal('hide');
                    },
                    error: function(xhr) {
                        console.log('Error:', xhr);
                    }
                });
            });

            // Edit Case Diary
            $('#caseDiaries-table').on('click', '.editCaseDiaryButton', function() {
                var caseDiaryId = $(this).data('id');
                $('#caseDiaryModalLabel').text('Edit Case Diary');
                var updateUrl = "{{ route('case-diaries.update', ['id' => ':id']) }}";
                updateUrl = updateUrl.replace(":id", caseDiaryId)
                $('#caseDiaryForm').attr('action', updateUrl);
                $('#method').val('PUT');

                var showUrl = "{{ route('case-diaries.show', ['id' => ':id']) }}";
                showUrl = showUrl.replace(":id", caseDiaryId)

                // Fetch case diary data and populate the form
                $.ajax({
                    url: showUrl,
                    method: 'GET',
                    success: function(response) {
                        $('#case_number').val(response.case_number);
                        $('#court_id').val(response.court_id);
                        $('#party_names').val(response.party_names);
                        $('#case_date').val(response.case_date);
                        $('#purpose').val(response.purpose);
                        $('#caseDiaryModal').modal('show');
                    },
                    error: function(xhr) {
                        console.log('Error fetching case diary:', xhr);
                    }
                });
            });

            // Delete Case Diary
            $('#caseDiaries-table').on('click', '.deleteCaseDiaryButton', function() {
                var caseDiaryId = $(this).data('id');
                var deleteUrl = "{{ route('case-diaries.delete', ['id' => ':id']) }}";
                deleteUrl = deleteUrl.replace(":id", caseDiaryId)
                if (confirm('Are you sure you want to delete this case diary?')) {
                    $.ajax({
                        url: deleteUrl,
                        data: {
                            "_token" : "{{@csrf_token()}}"
                        },
                        method: 'DELETE',
                        success: function(response) {
                            $('#caseDiaries-table').DataTable().ajax.reload();
                        },
                        error: function(xhr) {
                            console.log('Error deleting case diary:', xhr);
                        }
                    });
                }
            });
        });
    </script>
@endsection
