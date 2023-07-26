<?php

namespace App\Http\Controllers\Approver;

use App\Http\Controllers\Controller;
use App\Models\VehicleBooking;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vehicle = VehicleBooking::selectRaw('vehicles.number_plate,COUNT(vehicle_id) as total_pemakaian')
        ->rightJoin('vehicles',"vehicles.id","=","vehicle_bookings.vehicle_id")
        ->groupBy('vehicles.id')
        ->get();

        foreach($vehicle as $data){
            $plat[] = $data->number_plate;
            $pemakaian[] = $data->total_pemakaian;
        }


        return view('approver.dashboard',with([
            'plat'=>$plat,
            'pemakaian'=>$pemakaian
        ]));

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
        //
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
        //
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
        //
    }
}
