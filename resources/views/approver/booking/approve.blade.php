@extends('approver.layout')

@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Booking /</span> Disetujui</h4>

    <div class="row">
        <div class="col-12">
            <div class="card">
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
                            @forelse ($data as $data)
                                <tr>
                                    <td>{{ $data->id }}</td>
                                    <td>{{ $data->vehicle->number_plate }}</td>
                                    <td>{{ $data->driver->name }}</td>
                                    <td>{{ $data->booking_date }}</td>
                                    <td>{{ $data->status }}</td>
                                    <td><button class="btn btn-sm btn-info" data-bs-toggle="modal"
                                            data-bs-target="#modalDetail{{ $data->id }}">Detail</button>
                                    </td>
                                    <div class="modal fade" id="modalDetail{{ $data->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Detail</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row mb-3">
                                                        <label class="col-sm-4 col-form-label"
                                                            for="basic-default-name">Vehicle</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                id="basic-default-name"
                                                                value="{{ $data->vehicle->number_plate }}" readonly />
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-sm-4 col-form-label"
                                                            for="basic-default-name">Driver</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                id="basic-default-name" value="{{ $data->driver->name }}"
                                                                readonly />
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-sm-4 col-form-label"
                                                            for="basic-default-name">Booking
                                                            Date</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                id="basic-default-name" value="{{ $data->booking_date }}"
                                                                readonly />
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-sm-4 col-form-label"
                                                            for="basic-default-name">Status</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                id="basic-default-name" value="{{ $data->status }}"
                                                                readonly />
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-sm-4 col-form-label"
                                                            for="basic-default-name">Approval
                                                            Level 1</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                id="basic-default-name"
                                                                value="{{ $data->approval1->name }}" readonly />
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-sm-4 col-form-label"
                                                            for="basic-default-name">Approval
                                                            Level 1 Datetime</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                id="basic-default-name"
                                                                value="{{ $data->approval_1_datetime }}" readonly />
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-sm-4 col-form-label"
                                                            for="basic-default-name">Approval
                                                            Level 2</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                id="basic-default-name"
                                                                value="{{ $data->approval2->name }}" readonly />
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-sm-4 col-form-label"
                                                            for="basic-default-name">Approval
                                                            Level 2 Datetime</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control"
                                                                id="basic-default-name"
                                                                value="{{ $data->approval_2_datetime }}" readonly />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
