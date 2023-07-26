@extends('admin.layout')

@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Booking</h4>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Booking</h5>
                    <a class="btn btn-sm btn-secondary" href="{{ route('report.excel') }}"> Export</a>
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
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('after-script')
    <script type="text/javascript">
        $(function() {


            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('report.index') }}",
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
                ]
            });





        });
    </script>
@endpush
