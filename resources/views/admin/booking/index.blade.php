@extends('admin.layout')

@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Booking</h4>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Booking</h5>
                    <button class="btn btn-sm btn-success" href="javascript:void(0)" id="createNewBooking"> + Add
                        Booking</button>
                </div>
                <div class="card-body">
                    <table class="table data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Vehicle</th>
                                <th>Driver</th>
                                <th>Date</th>
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
                    <form id="bookingForm" name="bookingForm" class="form-horizontal">
                        <input type="hidden" name="booking_id" id="booking_id">
                        <div class="form-group">
                            <label for="name" class="col-sm-4 control-label">Booking Date</label>
                            <div class="col-sm-12">
                                <input type="date" class="form-control" name="booking_date" id="boking_date" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Vehicle</label>
                            <div class="col-sm-12">
                                <select name="vehicle_id" id="vehicle_id" class="form-control">
                                    @foreach ($vehicle as $data)
                                        <option value="{{ $data->id }}">{{ $data->number_plate }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Driver</label>
                            <div class="col-sm-12">
                                <select name="driver_id" id="driver_id" class="form-control">
                                    @foreach ($driver as $data)
                                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-4 control-label">Approval 1</label>
                            <div class="col-sm-12">
                                <select name="approval_1" id="approval_1" class="form-control">
                                    @foreach ($approver as $data)
                                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Approval 2</label>
                            <div class="col-sm-12">
                                <select name="approval_2" id="approval_2" class="form-control">
                                    @foreach ($approver as $data)
                                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                                    @endforeach
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
                ajax: "{{ route('booking.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'vehicle.number_plate',
                        name: 'vehicle.number_plate'
                    },
                    {
                        data: 'driver.name',
                        name: 'driver.name'
                    },
                    {
                        data: 'booking_date',
                        name: 'booking_date'
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




            $('#createNewBooking').click(function() {
                $('#saveBtn').val("create-booking");
                $('#vehicle_id').val('');
                $('#bookingForm').trigger("reset");
                $('#modelHeading').html("Create New Booking");
                modal.show();
            });


            // Button Edit
            $('body').on('click', '.editVehicleBooking', function() {
                var vehicle_id = $(this).data('id');
                $.get("{{ route('booking.index') }}" + '/' + vehicle_id + '/edit', function(data) {
                    $('#modelHeading').html("Edit Booking");
                    $('#saveBtn').val("edit-user");
                    $('#addDataModal').modal('show');
                    $('#booking_date').val(data.boking_date);
                    $('#vehicle_id').val(data.vehicle_id);
                    $('#driver_id').val(data.driver_id);
                    $('#approval_1').val(data.approval_1);
                    $('#approval_2').val(data.approval_2);


                })
            });

            // Action Save
            $('#saveBtn').click(function(e) {
                e.preventDefault();
                $(this).html('Sending..');

                $.ajax({
                    data: $('#bookingForm').serialize(),
                    url: "{{ route('booking.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {
                        $('#bookingForm').trigger("reset");
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
            $('body').on('click', '.deleteVehicleBooking', function() {

                var vehicle_id = $(this).data("id");
                confirm("Are You sure want to delete !");

                $.ajax({
                    type: "DELETE",
                    url: "{{ route('booking.store') }}" + '/' + vehicle_id,
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
