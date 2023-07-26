<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use App\Models\Mine;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $vehicle = Vehicle::with('mine')->get();
        $mine = Mine::get();
        if ($request->ajax()) {

            $data = Vehicle::with('mine')->get();

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editVehicle">Edit</a>';

                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteVehicle">Delete</a>';

                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
                }

        return view('admin.vehicle.index')->with([
            'vehicle'=>$vehicle,
            'mine'=>$mine
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
        Vehicle::updateOrCreate([
            'id' => $request->vehicle_id
        ],
        [
            'mine_id'=>$request->mine_id,
            'number_plate' => $request->number_plate,
            'vehicle_type' => $request->vehicle_type,
            'status'=>$request->status
        ]);

return response()->json(['success'=>'Vehicle saved successfully.']);

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
        $vehicle = Vehicle::find($id);
        return response()->json($vehicle);
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
        Vehicle::findOrFail($id)->delete();

        return response()->json(['success'=>'Vehicle deleted succesfully.']);
    }
}
