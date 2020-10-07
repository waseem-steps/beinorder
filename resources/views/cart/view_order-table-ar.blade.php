@extends('layouts.master-ar')
@section('content')

<!-- page content -->
<div class="right_col" role="main">
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>مراجعة الطلب</h2>
                    &nbsp;<a class="btn btn-round btn-success"
                        href="{{ Route('product-categories.rest-cat-ar',Session::get('ip_rest')) }}"><i
                            class="fa fa-plus-circle"></i></a>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-12">

                        </div>
                    </div>
                </div>
            </div>


            <div class="x_panel">
                <div class="x_title">
                    <h2>عناصر الطلب</h2>

                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <table class="table no-border">
                        <tbody>
                            @foreach($carts as $cart)
                            <tr>
                                <td>{{ $cart->ar_product_name }}
                                    @if($cart->ar_description!='-1')
                                    <p>({{ $cart->ar_description }})</p>
                                    @endif
                                    @if(!empty($cart->notes))
                                    <p>Notes: {{ $cart->notes }}</p>
                                    @endif
                                <td>{{ $cart->quantity}}</td>

                                </td>

                                <td>{{ $cart->price}}
                                    {{ App\Http\Controllers\CountryController::getCurrencyByProduct($cart->product_id) }}
                                </td>
                                <td><a class="btn btn-round btn-danger" href="
                                                    {{ Route('cart.delete-ar'
                                                    ,['product_id'=>$cart->product_id,
                                                    'ar_description'=>$cart->ar-description
                                                    ]
                                                    ) }}"><small><i class="fa fa-remove"></i></small></a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>



</div>
<div class="x_panel">
    <div class="x_title">
        <h2>كود الخصم</h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content text-center">
        <div class="row">
            <div class="col-xs-6">
                <input type="text" id="vou_code" name="vou_code" class="form-control ">
            </div>
            <div class="col-xs-6">
                <button id="apply" onclick="apply()" class="btn btn-round btn-success"><i
                        class="fa fa-check"></i></button>
                <button id="remove" onclick="remove()" class="btn btn-round btn-success" disabled=true><i
                        class="fa fa-remove"></i></button>
            </div>
        </div>
    </div>
</div>
<div class="x_panel">
    <div class="x_content text-center">
        <div class="row">
            <div class="col-md-12">
                المجموع: {{ App\Http\Controllers\CartController::getTotalAmount(Session::get('ip_address')) }}
            </div>
        </div>
    </div>
</div>
<div class="x_panel">
    <div class="x_content text-center">
        <div class="row">
            <div class="col-md-12">
                <a class="btn btn-round btn-success" href="{{ Route('cart.checkout-ar')}}">Go to checkout</a>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
@endsection
