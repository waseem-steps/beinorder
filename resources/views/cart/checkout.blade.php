@extends('layouts.master')
{{-- <script>
    $(function() {
  /* $(".numbers-row").append('<div class="inc button">+</div><div class="dec button">-</div>'); */
  $(".btn").on("click", function() {
    var $button = $(this);

    if ($button.text() == "Apply") {
  	 var inputs = document.getElementsByName("vou_code");
        inputs.disabled=true;
  	}

  });

});
</script> --}}
@section('content')
<script>
    function apply() {
    document.getElementById('apply').disabled = true;
    document.getElementById('remove').disabled = false;
}


function remove() {
document.getElementById('apply').disabled = false;
document.getElementById('remove').disabled = true;
}
</script>
<!-- page content -->
<div class="right_col" role="main">
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Checkout</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-12">

                        </div>
                    </div>
                </div>
            </div>
            <form id="create-menu" class="form-horizontal form-label-left" action="{{ Route('cart.final_confirm') }}"
                method="GET" enctype="multipart/form-data">
                {{csrf_field()  }}
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Customer Information</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="name">
                                        Name<span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="name" name="name" required="required"
                                            class="form-control ">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="phone_number">
                                        Phone Number<span class="required">*</span>
                                    </label>

                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="phone_number" name="phone_number" required="required"
                                            class="form-control "
                                            value="{{ (App\Http\Controllers\CountryController::countriesInter())[0]->int_code }}">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="email">
                                        Email
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="email" name="email" placeholder="Email (optional)"
                                            class="form-control ">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Car Information</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="car_name">
                                        Model<span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="car_name" name="car_name" required="required"
                                            class="form-control ">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="color">
                                        Color<span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="color" name="color" required="required"
                                            class="form-control ">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="license_number">
                                        License Number
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="license_number" name="license_number"
                                            placeholder="License Number (optional)" class="form-control ">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Payment Method</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <div class="item form-group">
                                    <div class="col-md-12 col-sm-12 text-left">
                                        <input type="radio" name="payment_method" checked class="flat" value="CASH">&nbsp;<i class="fa fa-money fa-lg"
                                            checked="checked"></i>&nbsp;Cash
                                        <input type="radio" name="payment_method"  class="flat" value="CREDIT">&nbsp;<i class="fa fa-cc-visa fa-lg"></i>&nbsp;E-Payment<br />

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="x_panel">
                    <div class="x_content text-center">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="submit" class="btn btn-round btn-success" value="Go to checkout" />
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
