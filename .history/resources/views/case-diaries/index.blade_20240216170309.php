@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Case Diaries</div>

                    <div class="card-body">
                        <!-- Create Case Diary Button -->
                        <button type="button" class="btn btn-primary mb-3" id="createCaseDiaryButton">
                            Create New Case Diary
                        </button>

                        <!-- Case Diaries Table -->
                        <table id="case-diaries-table" class="table table-bordered">
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
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="caseDiaryModalLabel">Create New Case Diary</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form for creating/editing a case diary -->
                    <form id="caseDiaryForm">
                        @csrf
                        <div class="form-group">
                            <label for="case_number">Case Number</label>
                            <input type="text" class="form-control" id="case_number" name="case_number"
                                placeholder="Enter case number">
                        </div>
                        <div class="form-group">
                            <label for="court_id">Court</label>
                            <select class="form-control" id="court_id" name="court_id">
                                <!-- Populate courts dynamically -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="party_names">Party Names</label>
                            <textarea class="form-control" id="party_names" name="party_names" placeholder="Enter party names"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="case_date">Case Date</label>
                            <input type="date" class="form-control" id="case_date" name="case_date">
                        </div>
                        <div class="form-group">
                            <label for="purpose">Purpose</label>
                            <input type="text" class="form-control" id="purpose" name="purpose"
                                placeholder="Enter purpose">
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
            $('#case-diaries-table').DataTable({
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
                        data: 'court_name',
                        name: 'court_name'
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
                    }
                ]
            });

            // Show create/edit modal on button click
            $('#createCaseDiaryButton').click(function() {
                $('#caseDiaryModal').modal('show');
                $('#caseDiaryModalLabel').text('Create New Case Diary');
                $('#caseDiaryForm').attr('action', '{{ route('case-diaries.store') }}');
                $('#case_number').val('');
                $('#court_id').val('');
                $('#party_names').val('');
                $('#case_date').val('');
                $('#purpose').val('');
            });

            // Handle form submission for create/edit
            $('#caseDiaryForm').submit(function(event) {
                event.preventDefault();
                var formData = $(this).serialize();
                var action = $(this).attr('action');
                $.ajax({
                    url: action,
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#case-diaries-table').DataTable().ajax.reload();
                        $('#caseDiaryModal').modal('hide');
                        toastr.success(response.message);
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON.errors);
                    }
                });
            });
        });
    </script>
@endsection
