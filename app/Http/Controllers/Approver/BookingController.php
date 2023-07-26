<?php

namespace App\Http\Controllers\Approver;

use App\Exports\BookingExport;
use Illuminate\Http\Request;
use App\Models\VehicleBooking;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class BookingController extends Controller
{
    public function pending()
    {
        $approval_1 = VehicleBooking::with(['vehicle','driver','approval1','approval2'])->where('approval_1',auth()->user()->id)
        ->where('status','Pending')
        ->get();
        $approval_2 = VehicleBooking::with(['vehicle','driver','approval1','approval2'])->where('approval_2',auth()->user()->id)
        ->where('status','Pending')
        ->orWhere('status','Approval Level 1')
        ->get();

        return view('approver.booking.pending',with([
            'approval_1'=>$approval_1,
            'approval_2'=>$approval_2
        ]));
    }

    public function approve()
    {
        $data = VehicleBooking::with(['vehicle','driver','approval1','approval2'])->where('status','approve')->get();

        return view('approver.booking.approve',with([
            'data'=>$data,
        ]));
    }

    public function reject()
    {
        $data = VehicleBooking::with(['vehicle','driver','approval1','approval2'])->where('status','Rejected Level 1')
        ->orWhere('status','Rejected Level 2')
        ->get();

        return view('approver.booking.reject',with([
            'data'=>$data,
        ]));
    }

    public function approval1($id)
    {
        $data = VehicleBooking::findOrFail($id);

        $data->update([
            'status' => 'Approve Level 1',
            'approval_1_datetime'=> date('Y-m-d H:i:s')
        ]);

        return redirect()->back();
    }


    public function approval2($id)
    {
        $data = VehicleBooking::findOrFail($id);

        $data->update([
            'status' => 'Approve',
            'approval_2_datetime'=> date('Y-m-d H:i:s')
        ]);

        return redirect()->back();
    }

    public function rejected1($id)
    {
        $data = VehicleBooking::findOrFail($id);

        $data->update([
            'status' => 'Rejected Level 1',
        ]);

        return redirect()->back();
    }


    public function rejected2($id)
    {
        $data = VehicleBooking::findOrFail($id);

        $data->update([
            'status' => 'Rejected Level 2',
        ]);

        return redirect()->back();
    }




}
