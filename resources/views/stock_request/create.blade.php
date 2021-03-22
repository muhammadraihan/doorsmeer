@extends('layouts.page')

@section('title', 'Stock Request Create')

@section('css')
<link rel="stylesheet" media="screen, print" href="{{asset('css/formplugins/select2/select2.bundle.css')}}">
@endsection

@section('content')
<div class="row">
    <div class="col-xl-6">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>Add New <span class="fw-300"><i>Stock Request</i></span></h2>
                <div class="panel-toolbar">
                    <a class="nav-link active" href="{{route('stock_request.index')}}"><i class="fal fa-arrow-alt-left">
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
                    {!! Form::open(['route' => 'stock_request.store','method' => 'POST','class' =>
                    'needs-validation','novalidate']) !!}
                    <div class="form-group col-md-4 mb-3">
                        {{ Form::label('item_id', 'Nama Item',['class' => 'required form-label'])}}
                        {!! Form::select('item_id', $item, '', ['class' => 'select2 form-control'.($errors->has('item_id') ? 'is-invalid':''), 'required'
                        => '', 'placeholder' => 'Select Nama Item ...']) !!}
                        @if ($errors->has('item_id'))
                        <div class="invalid-feedback">{{ $errors->first('item_id') }}</div>
                        @endif
                    </div>
                    <div class="form-group col-md-4 mb-3">
                        {{ Form::label('amount','Jumlah Barang Request',['class' => 'required form-label'])}}
                        {{ Form::text('amount',null,['placeholder' => 'Jumlah Barang Request','class' => 'form-control '.($errors->has('amount') ? 'is-invalid':''),'required', 'autocomplete' => 'off'])}}
                        @if ($errors->has('amount'))
                        <div class="invalid-feedback">{{ $errors->first('amount') }}</div>
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