<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WashJob;
use App\Models\Package;
use App\Models\Vehicle;

use Auth;
use DataTables;
use DB;
use File;
use Hash;
use Image;
use Response;
use URL;

class WashJobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $washjob = WashJob::all();
        // dd($washjob->all());
        if (request()->ajax()) {
            $data = WashJob::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('created_by',function($row){
                        return $row->userCreate->name;
                    })
                    ->editColumn('edited_by',function($row){
                        if($row->edited_by != null){
                        return $row->userEdit->name;
                        }else{
                            return null;
                        }
                    })
                    ->editColumn('vehicle_type', function($row){
                        if($row->vehicle_type == 1){
                           return 'Motor';
                        }else{
                           return 'Mobil';
                        }
                    })
                    ->editColumn('package_id',function($row){
                        return $row->packageId->name;
                    })
                    ->editColumn('status', function($row){
                        if($row->status == 1){
                           return 'Sedang Dicuci';
                        }else{
                           return 'Selesai';
                        }
                    })
                    ->addColumn('action', function($row){
                        return '
                        <a class="btn btn-success btn-sm btn-icon waves-effect waves-themed" href="'.route('washjob.edit',$row->uuid).'"><i class="fal fa-edit"></i></a>';
                 })
            ->removeColumn('id')
            ->removeColumn('uuid')
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('washjob.index');
    }

    public function vehicleName(Request $request){
        $vehicle_name = [];
        $vehicle_name = vehicle::where('vehicle_type', $request['param'])->get();
        // dd($request['param']);
        return response()->json($vehicle_name);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $vehicle_name = Vehicle::all()->pluck('name', 'uuid');
        $package_id = Package::all()->pluck('name', 'uuid');
        return view('washjob.create', compact('package_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'package_id' => 'required',
            'vehicle_type' => 'required',
            'vehicle_name' => 'required',
            'vehicle_register' => 'required',
            'status' => 'required',
        ];

        $messages = [
            '*.required' => 'Field tidak boleh kosong !',
        ];

        $this->validate($request, $rules, $messages);
        // dd($request->all());

        $washjob = new WashJob();
        $washjob->package_id = $request->package_id;
        $washjob->vehicle_type = $request->vehicle_type;
        $washjob->vehicle_name = $request->vehicle_name;
        $washjob->vehicle_register = $request->vehicle_register;
        $washjob->status = $request->status;
        $washjob->created_by = Auth::user()->uuid;

        $washjob->save();        

        
        toastr()->success('New Wash Job Added','Success');
        return redirect()->route('washjob.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $vehicle_name = Vehicle::all()->pluck('name', 'uuid');
        $package_id = Package::all()->pluck('name', 'uuid');
        $washjob = WashJob::uuid($id);
        return view('washjob.edit', compact('package_id', 'washjob'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'package_id' => 'required',
            'vehicle_type' => 'required',
            'vehicle_name' => 'required',
            'vehicle_register' => 'required',
            'status' => 'required',
        ];

        $messages = [
            '*.required' => 'Field tidak boleh kosong !',
        ];

        $this->validate($request, $rules, $messages);
        dd($request->all());

        $washjob = WashJob::uuid($id);
        $washjob->package_id = $request->package_id;
        $washjob->vehicle_type = $request->vehicle_type;
        $washjob->vehicle_name = $request->vehicle_name;
        $washjob->vehicle_register = $request->vehicle_register;
        $washjob->status = $request->status;
        $washjob->edited_by = Auth::user()->uuid;

        $washjob->save();        

        
        toastr()->success('Wash Job Edited','Success');
        return redirect()->route('washjob.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
