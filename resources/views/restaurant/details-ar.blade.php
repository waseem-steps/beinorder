@extends('layouts.master-AR')

@section('content')
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>{{ $rest->ar_rest_name }}</h3>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="">
            @foreach($prod_types as $type)
            <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>{{ $type->ar_type_name }}</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    @foreach($products as $product)
                    <form id="{{ $product->id }}" data-parsley-validate class="form-horizontal form-label-left"
                        action="{{ Route('order_details.store-ar') }}" method="GET">
                        {{csrf_field()  }}
                        <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="rest_id" id="rest_id" value="{{ $rest->id }}">
                        @if($type->ar_type_name==$product->productType->ar_type_name)
                        <div class="x_content">
                            <div class="col-md-7 col-sm-7 ">
                                <div class="product-image">
                                    <img src="{{asset('images\products\\').$product->img_path}}" />
                                </div>
                            </div>

                            <div class="col-md-5 col-sm-5 " style="border:0px solid #e5e5e5;">

                                <h3 class="prod_title">{{ $product->ar_product_name }}</h3>

                                <p>{{ $product->ar_product_description }}</p>
                                <br />
                                <div class="">
                                    <div class="product_price">
                                        <h1 class="price">{{ $product->price }} {{ $rest->country->currency_symbol }}
                                        </h1>
                                    </div>
                                </div>

                                <div class="">
                                    <h2>الحجم <small>اختر واحد</small></h2>
                                    <ul class="list-inline prod_size display-layout">
                                        @foreach ($sizes as $size)
                                        @if($size->product_id==$product->id)
                                        <input type="radio" class="flat" name="size_id" id="size_id"
                                            value="{{ $size->id }}" required />&nbsp;{{ $size->ar_size_name }}
                                        ( {{ $size->price }} {{ $rest->country->ar_currency_symbol }} )
                                        @endif
                                        @endforeach
                                    </ul>
                                </div>
                                <br />

                                <div class="">
                                    <h2>الإضافات <small>اختر</small></h2>
                                    <ul class="list-inline prod_size display-layout">
                                        @foreach ($product->extras() as $extra)
                                        <input type="checkbox" class="flat" name="extra" id="{{ $extra->id }}"
                                            value="{{ $extra->id }}" />{{ $extra->ar_extra_name }}
                                        @endforeach
                                    </ul>
                                </div>
                                <br />

                                <div class="">
                                    <button type="submit" class="btn btn-round btn-success"><i
                                            class="fa fa-shopping-cart"></i> إضافة إلى السلة</button>
                                    {{-- <a class="btn btn-round btn-primary" href="{{ $product->id }}"><i
                                        class="fa fa-shopping-cart"></i> Add to
                                    Cart</a> --}}
                                </div>
                            </div>
                        </div>
                        @endif
                    </form>

                    @endforeach
                </div>
            </div>
            @endforeach

        </div>
        <div class="clearfix"></div>
    </div>
    <!-- /page content -->
    @endsection
