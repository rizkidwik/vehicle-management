@extends('approver.layout')

@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Booking /</span> Menunggu Persetujuan</h4>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Approval 1</h5>
                </div>
                <div class="card-body">
                    <table class="table">
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
                        <tbody class="table-border-bottom-0">
                            @php $i=1 @endphp

                            @forelse ($approval_1 as $data)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $data->vehicle->number_plate }}</td>
                                    <td>{{ $data->driver->name }}</td>
                                    <td>{{ $data->booking_date }}</td>
                                    <td>{{ $data->status }}</td>
                                    <td>
                                        @if (!$data->approval_1_datetime)
                                            <a href="{{ route('booking.approve1', $data->id) }}"><span
                                                    class="badge badge-center rounded-pill bg-success"
                                                    data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top"
                                                    data-bs-html="true" title="<span>Setuju</span>"><i
                                                        class='bx bx-check'></i></span></a>
                                            <a href="{{ route('booking.rejected1', $data->id) }}"><span
                                                    class="badge badge-center rounded-pill bg-danger"
                                                    data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top"
                                                    data-bs-html="true" title="<span>Tolak</span>"><i
                                                        class='bx bx-x'></i></span></a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Data Kosong</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Approval 2</h5>
                </div>
                <div class="card-body">
                    <table class="table">
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
                        <tbody class="table-border-bottom-0">
                            @php $x=1 @endphp

                            @forelse ($approval_2 as $data)
                                <tr>
                                    <td>{{ $x++ }}</td>
                                    <td>{{ $data->vehicle->number_plate }}</td>
                                    <td>{{ $data->driver->name }}</td>
                                    <td>{{ $data->booking_date }}</td>
                                    <td>{{ $data->status }}</td>
                                    <td>
                                        @if (!$data->approval_2_datetime && $data->approval_1_datetime && $data->status == 'Approve Level 1')
                                            <a href="{{ route('booking.approve2', $data->id) }}"><span
                                                    class="badge badge-center rounded-pill bg-success"
                                                    data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top"
                                                    data-bs-html="true" title="<span>Setuju</span>"><i
                                                        class='bx bx-check'></i></span></a>
                                            <a href="{{ route('booking.rejected2', $data->id) }}"><span
                                                    class="badge badge-center rounded-pill bg-danger"
                                                    data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top"
                                                    data-bs-html="true" title="<span>Tolak</span>"><i
                                                        class='bx bx-x'></i></span></a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Data Kosong</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
