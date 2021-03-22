@extends('layouts.page')

@section('title', 'Stock Create')

@section('css')
<link rel="stylesheet" media="screen, print" href="{{asset('css/formplugins/select2/select2.bundle.css')}}">
@endsection

@section('content')
<div class="row">
    <div class="col-xl-6">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>Add New <span class="fw-300"><i>Stock</i></span></h2>
                <div class="panel-toolbar">
                    <a class="nav-link active" href="{{route('stock.index')}}"><i class="fal fa-arrow-alt-left">
                        </i>
                        <span class="nav-link-text">Back</span>
                    </a>
                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip"
                        data-offset="0,10" data-original-title="Fullscreen"></button>
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <div class="panel-tag">
                        Form with <code>*</code> can not be empty.
                    </div>
                    {!! Form::open(['route' => 'stock.store','method' => 'POST','class' =>
                    'needs-validation','novalidate']) !!}
                    <div class="form-group col-md-4 mb-3">
                        {{ Form::label('item_type_id', 'Tipe Item',['class' => 'required form-label'])}}
                        {!! Form::select('item_type_id', $item_type_id, '', ['class' => 'select2 form-control'.($errors->has('item_type_id') ? 'is-invalid':''), 'required'
                        => '', 'placeholder' => 'Select Tipe Item ...']) !!}
                        @if ($errors->has('item_type_id'))
                        <div class="invalid-feedback">{{ $errors->first('item_type_id') }}</div>
                        @endif
                    </div>
                    <div class="form-group col-md-4 mb-3">
                        {{ Form::label('item_name','Nama Item',['class' => 'required form-label'])}}
                        {{ Form::text('item_name',null,['placeholder' => 'Nama Item','class' => 'form-control '.($errors->has('item_name') ? 'is-invalid':''),'required', 'autocomplete' => 'off'])}}
                        @if ($errors->has('item_name'))
                        <div class="invalid-feedback">{{ $errors->first('item_name') }}</div>
                        @endif
                    </div>
                    <div class="form-group col-md-4 mb-3">
                        {{ Form::label('amount','Jumlah Stok Barang',['class' => 'required form-label'])}}
                        {{ Form::text('amount',null,['placeholder' => 'Jumlah Stok Barang','class' => 'form-control '.($errors->has('amount') ? 'is-invalid':''),'required', 'autocomplete' => 'off'])}}
                        @if ($errors->has('amount'))
                        <div class="invalid-feedback">{{ $errors->first('amount') }}</div>
                        @endif
                    </div>
                    <div class="form-group col-md-4 mb-3">
                        {{ Form::label('unit_name','Jenis Satuan',['class' => 'required form-label'])}}
                        {!! Form::select('unit_name', $unit_name, '', ['class' => 'select2 form-control'.($errors->has('unit_name') ? 'is-invalid':''), 'required'
                        => '', 'placeholder' => 'Select Jenis Satuan ...']) !!}
                        @if ($errors->has('unit_name'))
                        <div class="invalid-feedback">{{ $errors->first('unit_name') }}</div>
                        @endif
                    </div>
                    <div class="form-group col-md-4 mb-3">
                        {{ Form::label('unit_price','Harga Unit',['class' => 'required form-label'])}}
                        <div class="input-group">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        Rp.
                                    </span>
                                </div>
                        {{ Form::text('unit_price',null,['placeholder' => '','class' => 'form-control '.($errors->has('unit_price') ? 'is-invalid':''),'required', 'autocomplete' => 'off', 'data-inputmask' => "'alias': 'currency','prefix': ''"])}}
                        @if ($errors->has('unit_price'))
                        <div class="invalid-feedback">{{ $errors->first('unit_price') }}</div>
                        @endif
                    </div>
                <div
                    class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
                    <button class="btn btn-primary ml-auto" type="submit">Submit</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{asset('js/formplugins/select2/select2.bundle.js')}}"></script>
<script src="{{asset('js/formplugins/inputmask/inputmask.bundle.js')}}"></script>
<script>
    $(document).ready(function(){
        $('.select2').select2();

        $(':input').inputmask();

        // Generate a password string
        function randString(){
            var chars = "abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNP123456789";
            var string_length = 8;
            var randomstring = '';
            for (var i = 0; i < string_length; i++) {
                var rnum = Math.floor(Math.random() * chars.length);
                randomstring += chars.substring(rnum, rnum + 1);
            }
            return randomstring;
        }
        
        // Create a new password
        $(".getNewPass").click(function(){
            var field = $('#password').closest('div').find('input[name="password"]');
            field.val(randString(field));
        });
    });
</script>
@endsection