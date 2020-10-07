@extends('layouts.master-ar')
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
            <form id="create-menu" class="form-horizontal form-label-left" action="{{ Route('order.store-ar') }}" method="POST"
                enctype="multipart/form-data">
                {{csrf_field()  }}
                <div class="x_panel">
                    <div class="x_title">
                        <h2>مراجعة العناصر</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-md-12">
                                @foreach($carts as $cart)
                                <div class="x_panel">
                                    <div class="x_content">

                                      <table class="table no-border">
                                        <tbody>

                                            <tr>
                                                <td>{{ $cart->ar_product_name }}
                                                    @if($cart->ar_description!='-1')
<p>{{ $cart->ar_description }}</p>
                                                    @endif
                                                    @if(!empty($cart->notes))
                                                    <p>الملاحظات: {{ $cart->notes }}</p>
                                                    @endif
                                                </td>

                                                <td>{{ $cart->quantity}}</td>
                                                <td>{{ $cart->price}} {{ App\Http\Controllers\CountryController::getCurrencyByProduct($cart->product_id) }}
                                                </td>
                                                {{-- <td><a class="btn btn-round btn-danger" href="
                                                                                        {{ Route('cart.delete'
                                                                                        ,['product_id'=>$cart->product_id
                                                                                        ,'submenu_id'=>$cart->submenu_id
                                                                                        ,'submenu_item_id'=>$cart->submenu_item_id
                                                                                        ]
                                                                                        ) }}"><small><i class="fa fa-remove"></i></small></a></td> --}}
                                            </tr>

                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="x_panel">
                    <div class="x_title">
                        <h2>معلومات المطعم</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="name">
                                        اسم المطعم
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="name" name="name" readonly class="form-control "
                                            value="{{ App\Http\Controllers\BranchController::getRestName() }}">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="branch_name">
                                        اسم الفرع
                                    </label>

                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="branch_name" name="branch_name" readonly class="form-control "
                                            value="{{App\Http\Controllers\BranchController::getBranchName() }}">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="x_panel">
                    <div class="x_title">
                        <h2>معلومات الزبون</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="name">
                                        الاسم
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="name" name="name" readonly class="form-control "
                                            value="{{ $cust_name }}">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="phone_number">
                                        رقم الهاتف
                                    </label>

                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="phone_number" name="phone_number" readonly
                                            class="form-control " value="{{ $cust_mobile }}">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="email">
                                        الايميل
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="email" name="email" placeholder="Email (optional)"
                                            readonly class="form-control " value="{{ $cust_email }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="x_panel">
                    <div class="x_title">
                        <h2>معلومات السيارة</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="car_name">
                                        الموديل
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="car_name" name="car_name" readonly class="form-control "
                                            value="{{ $car_name }}">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="color">
                                        اللون
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="color" name="color" readonly class="form-control "
                                            value="{{ $car_color }}">
                                    </div>
                                </div>
                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="name">
                                        رقم اللوحة
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="license_number" name="license_number" readonly
                                            placeholder="License Number (optional)" class="form-control"
                                            value="{{ $license_number }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="x_panel">
                    <div class="x_title">
                        <h2>طريقة الدفع</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <div class="item form-group">
                                    <div class="col-md-12 col-sm-12 ">
                                        @if($payment_method=="CASH")
                                        <button class="btn" disabled>
                                            <i class="fa fa-money fa-5x"></i>
                                            <br />
                                            كاش
                                        </button>

                                        @else
                                        <button class="btn" disabled>
                                            <i class="fa fa-cc-mastercard fa-5x"></i>
                                            <br />
                                            الكتروني
                                        </button>
                                        @endif
<input type="hidden" name="payment_method" value={{  $payment_method}}>

                                        {{-- <input type="button" id="license_number" name="license_number"
                                            placeholder="License Number (optional)" class="form-control "> --}}
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
                            <input type="submit" onClick="this.form.submit(); this.disabled=true;" class="btn btn-round btn-success" value="إضافة طلب" />
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection
