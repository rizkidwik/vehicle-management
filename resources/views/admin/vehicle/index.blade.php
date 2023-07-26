@extends('admin.layout')

@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Vehicle</h4>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Vehicle</h5>
                    <button class="btn btn-sm btn-success" href="javascript:void(0)" id="createNewVehicle"> + Add
                        Vehicle</button>
                </div>
                <div class="card-body">
                    <table class="table data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Mine</th>
                                <th>Number Plate</th>
                                <th>Vehicle Type</th>
                                <th>Status</th>
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
                    <form id="vehicleForm" name="vehicleForm" class="form-horizontal">
                        <input type="hidden" name="vehicle_id" id="vehicle_id">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Mine</label>
                            <div class="col-sm-12">
                                <select name="mine_id" id="mine_id" class="form-control">
                                    @foreach ($mine as $data)
                                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-4 control-label">Number Plate</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="number_plate" name="number_plate"
                                    placeholder="Enter Number Plate" value="" maxlength="50" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-4 control-label">Vehicle Type</label>
                            <div class="col-sm-12">
                                <select name="vehicle_type" id="vehicle_type" class="form-control">
                                    <option value="angkutan_orang">Angkutan Orang</option>
                                    <option value="angkutan_barang">Angkutan Barang</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Status</label>
                            <div class="col-sm-12">
                                <select name="status" id="status" class="form-control">
                                    <option value="milik">Milik Perusahaan</option>
                                    <option value="sewa">Sewa</option>
                                </select>
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
                ajax: "{{ route('vehicle.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'mine.name',
                        name: 'minename'
                    },
                    {
                        data: 'number_plate',
                        name: 'number_plate'
                    },
                    {
                        data: 'vehicle_type',
                        name: 'vehicle_type'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });




            $('#createNewVehicle').click(function() {
                $('#saveBtn').val("create-vehicle");
                $('#vehicle_id').val('');
                $('#vehicleForm').trigger("reset");
                $('#modelHeading').html("Create New Vehicle");
                modal.show();
            });


            // Button Edit
            $('body').on('click', '.editVehicle', function() {
                var vehicle_id = $(this).data('id');
                $.get("{{ route('vehicle.index') }}" + '/' + vehicle_id + '/edit', function(data) {
                    $('#modelHeading').html("Edit Product");
                    $('#saveBtn').val("edit-user");
                    $('#addDataModal').modal('show');
                    $('#vehicle_id').val(data.id);
                    $('#mine_id').val(data.mine_id);
                    $('#name').val(data.name);
                    $('#number_plate').val(data.number_plate);
                    $('#vehicle_type').val(data.vehicle_type);
                    $('#status').val(data.status);

                })
            });

            // Action Save
            $('#saveBtn').click(function(e) {
                e.preventDefault();
                $(this).html('Sending..');

                $.ajax({
                    data: $('#vehicleForm').serialize(),
                    url: "{{ route('vehicle.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {
                        $('#vehicleForm').trigger("reset");
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
            $('body').on('click', '.deleteVehicle', function() {

                var vehicle_id = $(this).data("id");
                confirm("Are You sure want to delete !");

                $.ajax({
                    type: "DELETE",
                    url: "{{ route('vehicle.store') }}" + '/' + vehicle_id,
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
