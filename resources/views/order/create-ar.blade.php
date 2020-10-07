@extends('layouts.master')

@section('content')
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>طلب جديد</small></h3>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <form id="update-restaurant" data-parsley-validate class="form-horizontal form-label-left"
                    action="{{ Route('order_details.new_order-ar') }}" method="POST">
                    {{csrf_field()  }}
                    <input type="hidden" name="product_id" value="{{ $request->product_id }}" name="product_id">
                    <input type="hidden" name="size_id" value="1" name="size_id">
                    <input type="hidden" name="quantity" value="1" name="quantity">
                    <input type="hidden" name="d_notes" value="note" name="d_notes">
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="order_code">رمز الطلب
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                            <input type="text" readonly value="{{ $order_code }}" id="order_code"
                                name="order_code" required="required" class="form-control ">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="rest_name">اسم المطعم
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                            <input type="text" readonly value="{{ $rest->rest_name }}" id="rest_name"
                                name="rest_name" required="required" class="form-control ">
                        </div>
                    </div>
                    <input type="hidden" name="rest_id" id="rest_id" value="{{ $rest->id }}">

                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="branch_name">Branch Name
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                            <select class="form-control" id="branch" name="branch">
                                @foreach($rest->branches() as $branch)
                                <option value="{{ $branch->id }}">
                                    {{  $branch->branch_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="phone_number">Phone Number<span
                                class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                            <input type="text" id="phone_number" name="phone_number" required="required"
                                class="form-control ">
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="car_color">Car Color<span
                                class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                            <input type="text" id="car_color" name="car_color" required="required"
                                class="form-control ">
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="car_type">Car Type<span
                                class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                            <input type="text" id="car_type" name="car_type" required="required" class="form-control ">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="phone_number">Payment Type<span
                                class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                            <input type="radio" id="patyment_type" name="payment_type" required="required" value="1"
                                class="flat "> Cash
                            <input type="radio" id="patyment_type" name="payment_type" required="required" value="2"
                                class="flat"> E-Payment
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="notes">Notes<span
                                class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                            <textarea id="notes" name="notes" required="required" class="form-control "></textarea>
                        </div>
                    </div>



                    <div class="modal-footer">
                        <button class="btn btn-danger" type="reset">Reset</button>
                        <button type="submit" class="btn btn-success">Save
                            Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->
@endsection
