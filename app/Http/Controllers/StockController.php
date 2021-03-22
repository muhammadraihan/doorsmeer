<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Item;
use App\Models\Unit;

use Auth;
use DataTables;
use DB;
use File;
use Hash;
use Image;
use Response;
use URL;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stock = Stock::all();
        if (request()->ajax()) {
            $data = Stock::latest()->get();

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
                    ->editColumn('item_type_id',function($row){
                        return $row->itemType->name;
                    })
                    ->editColumn('unit_name',function($row){
                        return $row->unitName->name;
                    })
                    ->editColumn('unit_price',function($row){
                        return $row->unit_price ? 'Rp.'.' '.number_format($row->unit_price,2) : '' ;
                    })
                    ->addColumn('action', function($row){
                        return '
                        <a class="btn btn-success btn-sm btn-icon waves-effect waves-themed" href="'.route('stock.edit',$row->uuid).'"><i class="fal fa-edit"></i></a>
                        <a class="btn btn-danger btn-sm btn-icon waves-effect waves-themed delete-btn" data-url="'.URL::route('stock.destroy',$row->uuid).'" data-id="'.$row->uuid.'" data-token="'.csrf_token().'" data-toggle="modal" data-target="#modal-delete"><i class="fal fa-trash-alt"></i></a>';
                 })
            ->removeColumn('id')
            ->removeColumn('uuid')
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('stock.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item_type_id = Item::all()->pluck('name', 'uuid');
        $unit_name = Unit::all()->pluck('name', 'uuid');
        return view('stock.create', compact('item_type_id', 'unit_name'));
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
            'item_type_id' => 'required',
            'item_name' => 'required',
            'amount' => 'required',
            'unit_name' => 'required',
            'unit_price' => 'required'
        ];

        $messages = [
            '*.required' => 'Field tidak boleh kosong !',
        ];

        $this->validate($request, $rules, $messages);

        $unit_price = $request->unit_price;
        $formattedunit_price = str_replace(',', '', $unit_price);


        $stock = new Stock();
        $stock->item_type_id = $request->item_type_id;
        $stock->item_name = $request->item_name;
        $stock->amount = $request->amount;
        $stock->unit_name = $request->unit_name;
        $stock->unit_price = $formattedunit_price;
        $stock->created_by = Auth::user()->uuid;

        $stock->save();        

        
        toastr()->success('New Stock Added','Success');
        return redirect()->route('stock.index');
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
        $stock = Stock::uuid($id);
        $item_type_id = Item::all()->pluck('name', 'uuid');
        $unit_name = Unit::all()->pluck('name', 'uuid');
        return view('stock.edit', compact('stock', 'item_type_id', 'unit_name'));
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
            'item_type_id' => 'required',
            'item_name' => 'required',
            'amount' => 'required',
            'unit_name' => 'required',
            'unit_price' => 'required'
        ];

        $messages = [
            '*.required' => 'Field tidak boleh kosong !',
        ];

        $this->validate($request, $rules, $messages);

        $unit_price = $request->unit_price;
        $formattedunit_price = str_replace(',', '', $unit_price);

        $stock = Stock::uuid($id);
        $stock->item_type_id = $request->item_type_id;
        $stock->item_name = $request->item_name;
        $stock->amount = $request->amount;
        $stock->unit_name = $request->unit_name;
        $stock->unit_price = $formattedunit_price;
        $stock->edited_by = Auth::user()->uuid;

        $stock->save();        

        
        toastr()->success('Stock Edited','Success');
        return redirect()->route('stock.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $stock = Stock::uuid($id);
        $stock->delete();
        toastr()->success('Stock Deleted','Success');
        return redirect()->route('stock.index');
    }
}
