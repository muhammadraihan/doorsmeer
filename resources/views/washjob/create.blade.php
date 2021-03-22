@extends('layouts.page')

@section('title', 'Wash Job Create')

@section('css')
<link rel="stylesheet" media="screen, print" href="{{asset('css/formplugins/select2/select2.bundle.css')}}">
@endsection

@section('content')
<div class="row">
    <div class="col-xl-6">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>Add New <span class="fw-300"><i>Wash Job</i></span></h2>
                <div class="panel-toolbar">
                    <a class="nav-link active" href="{{route('washjob.index')}}"><i class="fal fa-arrow-alt-left">
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
                    {!! Form::open(['route' => 'washjob.store','method' => 'POST','class' =>
                    'needs-validation','novalidate']) !!}
                    <div class="form-group col-md-4 mb-3">
                        {{ Form::label('package_id','Tipe Paket Cuci',['class' => 'required form-label'])}}
                        {!! Form::select('package_id', $package_id, '', ['class' => 'select2 form-control'.($errors->has('package_id') ? 'is-invalid':''), 'required'
                        => '', 'placeholder' => 'Select Tipe Paket ...']) !!}
                        @if ($errors->has('package_id'))
                        <div class="invalid-feedback">{{ $errors->first('package_id') }}</div>
                        @endif
                    </div>
                    <div class="form-group col-md-4 mb-3">
                        {{ Form::label('vehicle_type','Tipe Kendaraan',['class' => 'required form-label'])}}
                        {!! Form::select('vehicle_type', array('1' => 'Motor', '2' => 'Mobil'), '',['class' => 'select-type form-control'.($errors->has('vehicle_type') ? 'is-invalid':''), 'required'
                        => '', 'placeholder' => 'Select Tipe Kendaraan ...']) !!}
                        @if ($errors->has('vehicle_type'))
                        <div class="invalid-feedback">{{ $errors->first('vehicle_type') }}</div>
                        @endif
                    </div>
                    <div class="form-group col-md-4 mb-3">
                        <div id="vehicleName" class="form-group col-md-20 mb-3" hidden>
                            <label class="required form-label">Nama Kendaraan</label>
                                <select name="vehicle_name" class="select-nama form-control" required autocomplete="off">
                            
                                </select>
                        </div>
                    </div>
                    <div class="form-group col-md-4 mb-3">
                        {{ Form::label('vehicle_register','Plat Kendaraan',['class' => 'required form-label'])}}
                        {{ Form::text('vehicle_register',null,['placeholder' => 'Plat Kendaraan', 'id' => 'vehicle_register','class' => 'form-control '.($errors->has('vehicle_register') ? 'is-invalid':''),'required', 'autocomplete' => 'off'])}}
                        @if ($errors->has('vehicle_register'))
                        <div class="invalid-feedback">{{ $errors->first('vehicle_register') }}</div>
                        @endif
                    </div>
                    <div class="form-group col-md-4 mb-3">
                        {{ Form::label('status','Status',['class' => 'required form-label'])}}
                        {!! Form::select('status', array('1' => 'Sedang Dicuci', '2' => 'Selesai'), '', ['class' => 'select2 form-control'.($errors->has('status') ? 'is-invalid':''), 'required'
                        => '', 'placeholder' => 'Select Status Pencucian ...']) !!}
                        @if ($errors->has('status'))
                        <div class="invalid-feedback">{{ $errors->first('status') }}</div>
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
        $('.select-type').select2();
        $('.select-nama').select2();
    
        $('.select-type').on('change', function(e){
            var uuid = $(this).val();

            $.ajax({
                url: "{{route('get.vehicleName')}}",
                type: 'GET',
                data: {param: uuid},
                success: function (response) {
                    $('#vehicleName').attr('hidden', false);
                    $.each(response, function(key,value){
                        // console.log(value,key);
                        $(".select-nama").append('<option value="'+ value.name +'">'+ value.name +'</option>');
                    });
                }
            });
        });

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