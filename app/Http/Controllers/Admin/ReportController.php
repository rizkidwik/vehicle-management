<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use Illuminate\Http\Request;
use App\Exports\BookingExport;
use App\Models\VehicleBooking;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $data = VehicleBooking::with(['vehicle','driver'])->get();
        if ($request->ajax()) {

            $data = VehicleBooking::with(['vehicle','driver'])->get();

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->make(true);
                }

        return view('admin.report.index',with([
            'data'=>$data,
        ]));
    }

    public function exportExcel()
    {

        $data = VehicleBooking::with(['vehicle','driver'])->get();

        $nama_file = 'Laporan - '. date('Ymd_Hi'). '.xlsx';

        return Excel::download(new BookingExport(
            'admin.report.report-excel',
            [
                'data'=>$data
            ]
        ), $nama_file, \Maatwebsite\Excel\Excel::XLSX, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ]);
    }
}
