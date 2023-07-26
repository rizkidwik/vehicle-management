@extends('approver.layout')

@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="">Dashboard Approver</h4>

    <div class="card">
        <div class="card-header">
            <h4>Grafik Peminjaman Kendaraan</h4>
        </div>
        <div class="card-body">
            <div id="chartPemakaian"></div>
        </div>
    </div>
@endsection

@push('after-script')
    <script>
        const dataTotal = {!! json_encode($pemakaian) !!}
        const dataPlat = {!! json_encode($plat) !!}
        const chartPemakaianEl = document.querySelector('#chartPemakaian'),

            chartPemakaianConfig = {
                series: [{
                    data: dataTotal
                }],
                chart: {
                    height: 215,
                    parentHeightOffset: 0,
                    parentWidthOffset: 0,
                    toolbar: {
                        show: false
                    },
                    type: 'area'
                },
                colors: [config.colors.primary],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 0.6,
                        opacityFrom: 0.5,
                        opacityTo: 0.25,
                        stops: [0, 95, 100]
                    }
                },

                xaxis: {
                    categories: dataPlat,
                },

            };
        if (typeof chartPemakaianEl !== undefined && chartPemakaianEl !== null) {
            const chartPemakaian = new ApexCharts(chartPemakaianEl, chartPemakaianConfig);
            chartPemakaian.render();
        }
    </script>
@endpush
