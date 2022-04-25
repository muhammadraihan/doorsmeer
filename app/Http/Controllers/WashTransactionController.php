<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WashTransaction;
use App\Models\WashJob;
use App\Models\Package;
use App\Models\Vehicle;
use App\Models\Item;
use App\Models\Stock;
use Carbon\Carbon;

use Auth;
use DataTables;
use DB;
use File;
use Hash;
use Image;
use Response;
use URL;

class WashTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $washtr = WashTransaction::all();
        // dd($washjob->all());
        if (request()->ajax()) {
            $data = WashTransaction::latest()->get();
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
                    ->editColumn('total',function($row){
                        return $row->total ? 'Rp.'.' '.number_format($row->total,2) : '' ;
                    })
                    ->editColumn('paid',function($row){
                        return $row->paid ? 'Rp.'.' '.number_format($row->paid,2) : '' ;
                    })->editColumn('change',function($row){
                        return $row->change ? 'Rp.'.' '.number_format($row->change,2) : '' ;
                    })
                    ->editColumn('status', function($row){
                        if($row->status == 1){
                           return 'Lunas';
                        }else{
                           return 'Belum Bayar';
                        }
                    })
                    ->editColumn('created_at',function($row){
                        return Carbon::parse($row->created_at)->format('l\\, j F Y H:i:s');
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

        return view('laporan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item_detail = Stock::all();
        $job_id = WashJob::all()->pluck('vehicle_register', 'uuid');
        $package= Package::all();
        $pricePackage = Package::select(DB::raw('price'))->get();
        // dd($pricePackage);
        $priceItem = Stock::select(DB::raw('unit_price'))->groupby('unit_price')->get();
        $data = [
            "item" => $item_detail,
            "package" => $package,
            "pricePackage" => $pricePackage,
            "priceItem" => $priceItem
        ];
        // dd($data);
        return view('transaction.wash', compact('job_id', 'data', 'package','pricePackage', 'priceItem'));
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
            'job_id' => 'required',
            'item_detail' => 'required',
            'total' => 'required',
            'paid' => 'required',
            'change' => 'required',
            'status' => 'required',
        ];

        $messages = [
            '*.required' => 'Field tidak boleh kosong !',
        ];

        $this->validate($request, $rules, $messages);
        dd($request->all());

        $washtransaction = new WashTransaction();
        $washtransaction->job_id = $request->job_id;
        $washtransaction->item_detail = $request->detail;
        $washtransaction->total = $request->total;
        $washtransaction->paid = $request->paid;
        $washtransaction->change = $request->change;
        $washtransaction->status = $request->status;
        $washtransaction->created_by = Auth::user()->uuid;

        // $washtransaction->save();        

        
        // toastr()->success('New Wash Job Added','Success');
        // return redirect()->route('washtransaction.create');
    }

    public function pricePackage(Request $request){
        $price = Package::where('uuid', $request['price'])->get();
        // dd($request['param']);
        return response()->json($price);
    }

    public function priceItem(Request $request){
        $price = Stock::where('uuid', $request['price'])->get();
        return response()->json($price);
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
        //
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
        //
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
