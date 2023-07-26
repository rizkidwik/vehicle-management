<?php

namespace App\Http\Controllers\Approver;

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
        $params=$request->all();
        if ($request->ajax()) {

            $data = VehicleBooking::with(['vehicle','driver'])
        ->where('approval_1',auth()->user()->id)
        ->orWhere('approval_2',auth()->user()->id)
            ->get();

            $tgl_awal = $request->get('tanggal_awal');
            $tgl_akhir = $request->get('tanggal_akhir');
            if($tgl_awal && $tgl_akhir){
                $data = VehicleBooking::with(['vehicle','driver'])
                ->whereBetween('booking_date',[$tgl_awal,$tgl_akhir])
                ->where(function ($query) {
                    $query->where('approval_1', auth()->user()->id)
                          ->orWhere('approval_2', auth()->user()->id);
                })
                ->get();
            }

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->make(true);
                }

        return view('approver.report.index',with([
            'params'=>$params
        ]));
    }

    public function exportExcel(Request $request)
    {

        $tgl_awal = $request->get('tanggal_awal');
        $tgl_akhir = $request->get('tanggal_akhir');


        $data = VehicleBooking::with(['vehicle','driver'])
        ->where('approval_1',auth()->user()->id)
        ->orWhere('approval_2',auth()->user()->id)
        ->get();

        if($tgl_awal && $tgl_akhir){
            $data = VehicleBooking::with(['vehicle','driver'])
            ->whereBetween('booking_date',[$tgl_awal,$tgl_akhir])
            ->where(function ($query) {
                $query->where('approval_1', auth()->user()->id)
                      ->orWhere('approval_2', auth()->user()->id);
            })
            ->get();
        }

        $nama_file = 'Laporan - '. date('Ymd_Hi'). '.xlsx';

        return Excel::download(new BookingExport(
            'approver.report.report-excel',
            [
                'tgl_awal'=>$tgl_awal,
                'tgl_akhir'=>$tgl_akhir,
                'data'=>$data
            ]
        ), $nama_file, \Maatwebsite\Excel\Excel::XLSX, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ]);
    }
}
