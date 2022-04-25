@extends('layouts.page')

@section('title', 'Wash Transaction Create')

@section('css')
<link rel="stylesheet" media="screen, print" href="{{asset('css/formplugins/select2/select2.bundle.css')}}">
@endsection

@section('content')
<div class="row">
    <div class="col-xl-6">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>Add New <span class="fw-300"><i>Wash Transaction</i></span></h2>
                <div class="panel-toolbar">
                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip"
                        data-offset="0,10" data-original-title="Fullscreen"></button>
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <div class="panel-tag">
                        Form with <code>*</code> can not be empty.
                    </div>
                    {!! Form::open(['route' => 'washtransaction.store','method' => 'POST','class' =>
                    'needs-validation','novalidate']) !!}
                    <div class="form-group col-md-4 mb-3">
                        {{ Form::label('job_id','Plat Kendaraan',['class' => 'required form-label'])}}
                        {!! Form::select('job_id', $job_id, '', ['class' => 'select-plat form-control'.($errors->has('job_id') ? 'is-invalid':''), 'required'
                        => '', 'placeholder' => 'Select Plat Kendaraan ...']) !!}
                        @if ($errors->has('job_id'))
                        <div class="invalid-feedback">{{ $errors->first('job_id') }}</div>
                        @endif
                    </div>
                    <div id="box" class="form-row align-items-center panel-content">
                        <div class="form-group col-md-4 mb-3">
                            {{ Form::label('item_detail','Nama Item',['class' => 'required form-label'])}}
                                <select name="item_detail" class="select-items form-control">
                                    <option value="">Pilih Package</option>
                                    @foreach($data['package'] as $item)
                                        <option value="{{$item->uuid}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                        </div>
                        <div class="form-group col-sm-1 col-xl-1">
                            <label class="required form-label">Qty</label>
                            <input type="number" name="qty"
                                v-model="cart.qty" 
                                id="qty" value="1" 
                                min="1" class="form-control">
                        </div>                        
                        <div class="form-group col-sm-3 col-xl-3">
                            <label class="required form-label">Harga</label>
                            <div class="input-group" id="pricePackage">
                                <div class="input-group-append" name="price">
                                    <span class="input-group-text">
                                        Rp.
                                    </span>
                                    <span class="amount form-control" disabled="" name="amount[]" id="amount"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-auto">
                            <button id="addBox" type="button btn-group" class=" btn btn-info" ><i class="fal fa-plus"></i></button>
                        </div>
                            @if ($errors->has('item_detail'))
                            <div class="invalid-feedback">{{ $errors->first('item_detail') }}</div>
                            @endif
                    </div>
                    <div class="form-group col-md-4 mb-3">
                        {{ Form::label('total','Total',['class' => 'required form-label'])}}
                        <span class="total form-control" disabled=""></span>
                        @if ($errors->has('total'))
                        <div class="invalid-feedback">{{ $errors->first('total') }}</div>
                        @endif
                    </div>
                    <div class="form-group col-md-4 mb-3">
                        {{ Form::label('paid','Paid',['class' => 'required form-label'])}}
                        {{ Form::text('paid',null,['placeholder' => 'Paid','class' => 'form-control '.($errors->has('paid') ? 'is-invalid':''),'required', 'autocomplete' => 'off'])}}
                        @if ($errors->has('paid'))
                        <div class="invalid-feedback">{{ $errors->first('paid') }}</div>
                        @endif
                    </div>
                    <div class="form-group col-md-4 mb-3">
                        {{ Form::label('change','Change',['class' => 'required form-label'])}}
                        {{ Form::text('change',null,['placeholder' => 'Change','class' => 'form-control '.($errors->has('change') ? 'is-invalid':''),'required', 'autocomplete' => 'off', 'disabled'])}}
                        @if ($errors->has('change'))
                        <div class="invalid-feedback">{{ $errors->first('change') }}</div>
                        @endif
                    </div>
                    <div class="form-group col-md-4 mb-3">
                        {{ Form::label('status','Status',['class' => 'required form-label'])}}
                        {!! Form::select('status', array('1' => 'Lunas', '2' => 'Belum Bayar'), '',['class' => 'select-status form-control'.($errors->has('status') ? 'is-invalid':''), 'required'
                        => '', 'placeholder' => 'Select Status Pembayaran ...']) !!}
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
        $('.select-plat').select2();
        $('.select-package').select2();
        $('.select-items').select2();
        $('.select-status').select2();

        function TotalAmount(){
            var total = 0;

            $('.amount').each(function(i, e){
                var amount = $(this).val() - 0;
                total += amount;
            });

            $('.total').text(total);
        }

        $('.select-items').on('change', function(e){
            var price = $(this).val();

            $.ajax({
                url: '{{route('get.pricePackage')}}',
                type: "GET",
                data: {price: price},
                success: function (response) {
                    $('.amount').text(response[0].price);
                    var sum = 0;
                    var sumsum = 0;

                    $('#qty').on('change',function(e){
                        sum = $(this).val() * response[0].price;
                        $('.amount').text(sum);
                    });
                    // sum = $(this).val() * response[0].price;
                    //  if($.isNumeric(this.value)){
                    //     sumsum += parseFloat(this.value);
                    //     $('.total').text(sumsum);
                    // }
                }
            });
        });

        // add box
        var i = 0;
        $('#addBox').on('click', function(e){
            e.preventDefault();
            ++i;
            $('<div id="box"/>').addClass('input-group')
            .html( $('<div class="form-group col-sm-4 col-xl-4">{{ Form::label("item_detail","Nama Item",["class" => "required form-label"]) }}<select name="item_detail['+i+'][item]" class="item form-control"><option>Pilih Item</option>@foreach($data["item"] as $item)<option value="{{$item->uuid}}">{{$item->item_name}}</option>@endforeach</select></div>'))
            .append( $('<div class="form-group col-sm-1 col-xl-1"><label class="required form-label">Qty</label><input type="number" name="item_qty['+i+'][qty]" v-model="cart.qty" class="qtyItem form-control" value="1" min="1" class="form-control"></div>'))
            .append( $('<div class="form-group col-sm-3 col-xl-3"><label class="required form-label">Harga</label><div class="input-group"><div class="input-group-append"><span class="input-group-text">Rp.</span><span class="amountItem form-control" name="priceItem['+i+'][price]"></span></div></div></div>'))
            .append( $('<div class="form-group col-sm-1 col-xl-1"><br><button id="removeBox" class="btn btn-danger remove"><i class="fal fa-minus"></i></button></div>'))
            .insertAfter($('[id="box"]').last());

            $('.item').select2();
            $('.item').on('change', function(e){
                var priceItem = $(this).val();
                $.ajax({
                url: '{{route('get.priceItem')}}',
                type: "GET",
                data: {price: priceItem},
                    success: function (response) {
                        $('.amountItem').text(response[0].unit_price);
                        var sum = 0;
                        $('.qtyItem').on('change',function(e){
                            sum = $(this).val() * response[0].unit_price;
                            $('.amountItem').text(sum);
                        });
                    }
                });
            })
        });

      $(document).on('click','button.remove', function(e){
        e.preventDefault();
        $(this).closest( 'div.input-group').remove();
      });
        
    });
</script>
@endsection