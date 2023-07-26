<table width="100%" class="table">
    <thead>

        <tr>
            <th colspan="9" style="text-align: center"><strong>Laporan Pemesanan Kendaraan</strong></th>
        </tr>
        <tr>
            @if ($tgl_awal && $tgl_akhir)
                <th colspan="9" style="text-align: center"><strong>Periode :
                        {{ $tgl_awal . ' s/d ' . $tgl_akhir }}</strong></th>
            @endif
        </tr>
        <tr>
            <th>No</th>
            <th>Vehicle</th>
            <th>Driver</th>
            <th>Date</th>
            <th>Status</th>
            <th>Approval 1</th>
            <th>Approval 1 Datetime</th>
            <th>Approval 2</th>
            <th>Approval 2 Datetime</th>
        </tr>
    </thead>
    <tbody>
        @php $i=1;@endphp
        @foreach ($data as $data)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $data->vehicle->number_plate }}</td>
                <td>{{ $data->driver->name }}</td>
                <td>{{ $data->booking_date }}</td>
                <td>{{ $data->status }}</td>
                <td>{{ $data->approval_1 }}</td>
                <td>{{ $data->approval_1_datetime }}</td>
                <td>{{ $data->approval_2 }}</td>
                <td>{{ $data->approval_2_datetime }}</td>
            </tr>
        @endforeach


    </tbody>
</table>
