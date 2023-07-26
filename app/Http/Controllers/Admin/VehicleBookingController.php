<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use App\Models\Mine;
use App\Models\User;
use App\Models\Driver;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Models\VehicleBooking;
use App\Http\Controllers\Controller;

class VehicleBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $vehiclebooking = VehicleBooking::with(['vehicle','driver'])->get();
        $approver = User::where('level','approver')->get();
        $vehicle = Vehicle::get();
        $driver = Driver::get();
        if ($request->ajax()) {

            $data = VehicleBooking::with(['vehicle','driver'])->get();

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editVehicleBooking">Edit</a>';

                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteVehicleBooking">Delete</a>';

                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
                }

        return view('admin.booking.index')->with([
            'vehiclebooking'=>$vehiclebooking,
            'driver'=>$driver,
            'vehicle'=>$vehicle,
            'approver'=>$approver
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        VehicleBooking::updateOrCreate([
            'id' => $request->vehiclebooking_id
        ],
        [
            'vehicle_id'=>$request->vehicle_id,
            'driver_id'=>$request->driver_id,
            'booking_date'=>$request->booking_date,
            'status'=>"Pending",
            'approval_1' => $request->approval_1,
            'approval_2'=>$request->approval_2,
        ]);

return response()->json(['success'=>'VehicleBooking saved successfully.']);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $vehiclebooking = VehicleBooking::find($id);
        return response()->json($vehiclebooking);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        VehicleBooking::findOrFail($id)->delete();

        return response()->json(['success'=>'VehicleBooking deleted succesfully.']);
    }
}
