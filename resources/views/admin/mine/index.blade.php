@extends('admin.layout')

@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Mine</h4>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Mine</h5>
                    <button class="btn btn-sm btn-success" href="javascript:void(0)" id="createNewMine"> + Add
                        Mine</button>
                </div>
                <div class="card-body">
                    <table class="table data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Branch</th>
                                <th>Mine Name</th>
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
                    <form id="mineForm" name="mineForm" class="form-horizontal">
                        <input type="hidden" name="mine_id" id="mine_id">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Branch</label>
                            <div class="col-sm-12">
                                <select name="branch_id" id="branch_id" class="form-control">
                                    @foreach ($branch as $data)
                                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter Name" value="" maxlength="50" required>
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
                ajax: "{{ route('mine.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'branch.name',
                        name: 'branch.name'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });




            $('#createNewMine').click(function() {
                $('#saveBtn').val("create-mine");
                $('#mine_id').val('');
                $('#mineForm').trigger("reset");
                $('#modelHeading').html("Create New Mine");
                modal.show();
            });


            // Button Edit
            $('body').on('click', '.editMine', function() {
                var mine_id = $(this).data('id');
                $.get("{{ route('mine.index') }}" + '/' + mine_id + '/edit', function(data) {
                    $('#modelHeading').html("Edit Product");
                    $('#saveBtn').val("edit-user");
                    $('#addDataModal').modal('show');
                    $('#mine_id').val(data.id);
                    $('#name').val(data.name);
                })
            });

            // Action Save
            $('#saveBtn').click(function(e) {
                e.preventDefault();
                $(this).html('Sending..');

                $.ajax({
                    data: $('#mineForm').serialize(),
                    url: "{{ route('mine.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {
                        $('#mineForm').trigger("reset");
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
            $('body').on('click', '.deleteMine', function() {

                var mine_id = $(this).data("id");
                confirm("Are You sure want to delete !");

                $.ajax({
                    type: "DELETE",
                    url: "{{ route('mine.store') }}" + '/' + mine_id,
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
