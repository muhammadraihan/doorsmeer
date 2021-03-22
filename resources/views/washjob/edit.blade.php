@extends('layouts.page')

@section('title', 'Wash Job Edit')

@section('css')
<link rel="stylesheet" media="screen, print" href="{{asset('css/formplugins/select2/select2.bundle.css')}}">
@endsection

@section('content')
<div class="row">
    <div class="col-xl-6">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
            <h2>Edit <span class="fw-300"><i>{{$washjob->vehicle_register}}</i></span></h2>
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
                    {!! Form::open(['route' => ['washjob.update',$washjob->uuid],'method' => 'PUT','class' =>
                    'needs-validation','novalidate']) !!}
                    <div class="form-group col-md-4 mb-3">
                        {{ Form::label('package_id','Tipe Paket Cuci',['class' => 'required form-label'])}}
                        {!! Form::select('package_id', $package_id, $washjob->package_id, ['class' => 'select2 form-control'.($errors->has('package_id') ? 'is-invalid':''), 'required'
                        => '', 'placeholder' => 'Select Tipe Paket ...']) !!}
                        @if ($errors->has('package_id'))
                        <div class="invalid-feedback">{{ $errors->first('package_id') }}</div>
                        @endif
                    </div>
                    <div class="form-group col-md-4 mb-3">
                        {{ Form::label('vehicle_type','Tipe Kendaraan',['class' => 'required form-label'])}}
                        {!! Form::select('vehicle_type', array('1' => 'Motor', '2' => 'Mobil'),  $washjob->vehicle_type, ['class' => 'select2 form-control'.($errors->has('vehicle_type') ? 'is-invalid':''), 'required'
                        => '', 'placeholder' => 'Select Tipe Kendaraan ...']) !!}
                        @if ($errors->has('vehicle_type'))
                        <div class="invalid-feedback">{{ $errors->first('vehicle_type') }}</div>
                        @endif
                    </div>
                    <div class="form-group col-md-4 mb-3">
                        {{ Form::label('vehicle_name','Nama Kendaraan',['class' => 'required form-label'])}}
                        {!! Form::select('vehicle_name',  $washjob->vehicle_name, ['class' => 'select2 form-control'.($errors->has('vehicle_name') ? 'is-invalid':''), 'required'
                        => '', 'placeholder' => 'Select Nama Kendaraan ...']) !!}
                        @if ($errors->has('vehicle_name'))
                        <div class="invalid-feedback">{{ $errors->first('vehicle_name') }}</div>
                        @endif
                    </div>
                    <div class="form-group col-md-4 mb-3">
                        {{ Form::label('vehicle_register','Nama Kendaraan',['class' => 'required form-label'])}}
                        {{ Form::text('vehicle_register', $washjob->vehicle_register, '',['placeholder' => 'Nama Kendaraan','class' => 'form-control '.($errors->has('vehicle_register') ? 'is-invalid':''),'required', 'autocomplete' => 'off'])}}
                        @if ($errors->has('vehicle_register'))
                        <div class="invalid-feedback">{{ $errors->first('vehicle_register') }}</div>
                        @endif
                    </div>
                    <div class="form-group col-md-4 mb-3">
                        {{ Form::label('status','Status',['class' => 'required form-label'])}}
                        {!! Form::select('status', array('1' => 'Sedang Dicuci', '2' => 'Selesai'), $washjob->status, ['class' => 'select2 form-control'.($errors->has('status') ? 'is-invalid':''), 'required'
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
<script>
    $(document).ready(function(){
        $('.select2').select2();
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

        //Enable input and button change password
        $('#enablePassChange').click(function() {
            if ($(this).is(':checked')) {
                $('#passwordForm').attr('disabled',false); //enable input
                $('#getNewPass').attr('disabled',false); //enable button
            } else {
                    $('#passwordForm').attr('disabled', true); //disable input
                    $('#getNewPass').attr('disabled', true); //disable button
            }
        });
    });
</script>
@endsection