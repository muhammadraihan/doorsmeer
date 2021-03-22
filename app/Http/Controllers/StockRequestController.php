<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock_request;
use App\Models\Item;

use Auth;
use DataTables;
use DB;
use File;
use Hash;
use Image;
use Response;
use URL;

class StockRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stock_request = Stock_request::all();
        if (request()->ajax()) {
            $data = Stock_request::latest()->get();

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
                    ->editColumn('item_id',function($row){
                        return $row->namaItem->name;
                    })
                    ->addColumn('action', function($row){
                        return '
                        <a class="btn btn-success btn-sm btn-icon waves-effect waves-themed" href="'.route('stock_request.edit',$row->uuid).'"><i class="fal fa-edit"></i></a>
                        <a class="btn btn-danger btn-sm btn-icon waves-effect waves-themed delete-btn" data-url="'.URL::route('stock_request.destroy',$row->uuid).'" data-id="'.$row->uuid.'" data-token="'.csrf_token().'" data-toggle="modal" data-target="#modal-delete"><i class="fal fa-trash-alt"></i></a>';
                 })
            ->removeColumn('id')
            ->removeColumn('uuid')
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('stock_request.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item = Item::all()->pluck('name', 'uuid');
        return view('stock_request.create', compact('item'));
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
            'item_id' => 'required',
            'amount' => 'required',
        ];

        $messages = [
            '*.required' => 'Field tidak boleh kosong !',
        ];

        $this->validate($request, $rules, $messages);

        $stock_request = new Stock_request();
        $stock_request->item_id = $request->item_id;
        $stock_request->amount = $request->amount;
        $stock_request->created_by = Auth::user()->uuid;

        $stock_request->save();        

        
        toastr()->success('New Stock request Added','Success');
        return redirect()->route('stock_request.index');
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
        $item = Item::all()->pluck('name', 'uuid');
        $stock_request = Stock_request::uuid($id);
        return view('stock_request.edit', compact('item', 'stock_request'));
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
            'item_id' => 'required',
            'amount' => 'required',
        ];

        $messages = [
            '*.required' => 'Field tidak boleh kosong !',
        ];

        $this->validate($request, $rules, $messages);

        $stock_request = Stock_request::uuid($id);
        $stock_request->item_id = $request->item_id;
        $stock_request->amount = $request->amount;
        $stock_request->edited_by = Auth::user()->uuid;

        $stock_request->save();        

        
        toastr()->success('Stock request Edited','Success');
        return redirect()->route('stock_request.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $stock_request = Stock_request::uuid($id);
        $stock_request->delete();
        toastr()->success('Stock Request Deleted','Success');
        return redirect()->route('stock_request.index');
    }
}
