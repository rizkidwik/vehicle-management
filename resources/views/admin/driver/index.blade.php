@extends('admin.layout')

@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Driver</h4>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Driver</h5>
                    <button class="btn btn-sm btn-success" href="javascript:void(0)" id="createNewDriver"> + Add
                        Driver</button>
                </div>
                <div class="card-body">
                    <table class="table data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Add Data --}}
    <div class="modal fade" id="addDataModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="driverForm" name="driverForm" class="form-horizontal">
                        <input type="hidden" name="driver_id" id="driver_id">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter Name" value="" maxlength="50" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Phone</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="phone" name="phone"
                                    placeholder="Enter Phone" value="" maxlength="50" required>
                            </div>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                    </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('after-script')
    <script type="text/javascript">
        $(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('addDataModal'));

            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('driver.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });




            $('#createNewDriver').click(function() {
                $('#saveBtn').val("create-driver");
                $('#driver_id').val('');
                $('#driverForm').trigger("reset");
                $('#modelHeading').html("Create New Driver");
                modal.show();
            });


            // Button Edit
            $('body').on('click', '.editDriver', function() {
                var driver_id = $(this).data('id');
                $.get("{{ route('driver.index') }}" + '/' + driver_id + '/edit', function(data) {
                    $('#modelHeading').html("Edit Product");
                    $('#saveBtn').val("edit-user");
                    $('#addDataModal').modal('show');
                    $('#driver_id').val(data.id);
                    $('#name').val(data.name);
                })
            });

            // Action Save
            $('#saveBtn').click(function(e) {
                e.preventDefault();
                $(this).html('Sending..');

                $.ajax({
                    data: $('#driverForm').serialize(),
                    url: "{{ route('driver.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {
                        $('#driverForm').trigger("reset");
                        modal.hide();
                        $('#saveBtn').html('Save Changes');

                        table.draw();
                    },
                    error: function(data) {
                        console.log('Error:', data);
                        $('#saveBtn').html('Save Changes');
                    }
                });
            });
            // Delete
            $('body').on('click', '.deleteDriver', function() {

                var driver_id = $(this).data("id");
                confirm("Are You sure want to delete !");

                $.ajax({
                    type: "DELETE",
                    url: "{{ route('driver.store') }}" + '/' + driver_id,
                    success: function(data) {
                        table.draw();
                    },
                    error: function(data) {
                        console.log('Error:', data);
                    }
                });
            });

        });
    </script>
@endpush
