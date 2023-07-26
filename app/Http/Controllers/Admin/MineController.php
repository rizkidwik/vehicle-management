<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use App\Models\Mine;
use App\Models\Branch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $mine = Mine::with('branch')->get();
        $branch = Branch::get();
        if ($request->ajax()) {

            $data = Mine::with('branch')->get();

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editMine">Edit</a>';

                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteMine">Delete</a>';

                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
                }

        return view('admin.mine.index')->with([
            'mine'=>$mine,
            'branch'=>$branch
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
        Mine::updateOrCreate([
            'id' => $request->mine_id
        ],
        [
            'branch_id'=>$request->branch_id,
            'name' => $request->name
        ]);

return response()->json(['success'=>'Mine saved successfully.']);

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
        $mine = Mine::find($id);
        return response()->json($mine);
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
        Mine::findOrFail($id)->delete();

        return response()->json(['success'=>'Mine deleted succesfully.']);
    }
}
