@extends('approver.layout')

@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Report</h4>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Report</h5>
                    <div class="">
                        @if ($params)
                            <a href="{{ url('report') }}" class="btn btn-danger btn-sm "><i class="fa fa-close"></i>Hapus
                                Filter</a>
                        @endif
                        <button data-bs-toggle="modal" data-bs-target="#modal-form-tanggal" class="btn btn-info btn-sm"><i
                                class="fa fa-plus-circle"></i>
                            Filter Tanggal</button>
                        <form action="{{ url('report/export') }}" method="post" style="display: inline-block">
                            @csrf
                            <input type="hidden" name="tanggal_awal" value="{{ request()->tanggal_awal }}">
                            <input type="hidden" name="tanggal_akhir" value="{{ request()->tanggal_akhir }}">
                            <button type="submit" class="btn btn-sm btn-secondary" href="{{ url('report/export') }}">
                                Export</button>
                        </form>
                    </div>
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

    <div class="modal fade" id="modal-form-tanggal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading">Filter Data</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('report') }}" method="get">
                        <div class="form-group row">
                            <label for="tanggal_awal" class="col-lg-4 col-lg-offset-1 control-label">Tanggal Awal</label>
                            <div class="col-lg-6">
                                <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control datepicker"
                                    required autofocus value="{{ request('tanggal_awal') }}"
                                    style="border-radius: 0 !important;">
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                        <div class="form-group row mt-3">
                            <label for="tanggal_akhir" class="col-lg-4 col-lg-offset-1 control-label">Tanggal Akhir</label>
                            <div class="col-lg-6">
                                <input type="date" name="tanggal_akhir" id="tanggal_akhir"
                                    class="form-control datepicker" required
                                    value="{{ request('tanggal_akhir') ?? date('Y-m-d') }}"
                                    style="border-radius: 0 !important;">
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Filter
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('after-script')
    <script type="text/javascript">
        $(function() {
            var tgl_awal = "{{ request()->tanggal_awal }}"
            var tgl_akhir = "{{ request()->tanggal_akhir }}"

            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    'type': 'get',
                    'url': "{{ url('report') }}",
                    'data': {
                        tanggal_awal: tgl_awal,
                        tanggal_akhir: tgl_akhir
                    }
                },
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
