@extends('layouts.master')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            {{-- <div class="title_left">
                <div class="input-group">
                    <button type="button" class="btn btn-round btn-success" data-toggle="modal"
                        data-target=".bs-example-modal-lg"><i class="fa fa-plus-circle"></i> New
                        Product</button>
                    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel">New Product</h4>
                                    <button type="button" class="close" data-dismiss="modal"><span
                                            aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="create-product" data-parsley-validate
                                        class="form-horizontal form-label-left"
                                        action="{{ Route('product.store',$cat_id) }}" method="POST"
            enctype="multipart/form-data">
            {{csrf_field()  }}
            <input type="hidden" name="cat_id" id="cat_id" value="{{ $cat_id }}" />
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="cat_name">Product
                    Name<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                    <input type="text" id="product_name" name="product_name" required="required" class="form-control ">
                </div>
            </div>
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="ar_product_name">Product Arabic
                    Name<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                    <input type="text" id="ar_product_name" name="ar_product_name" required="required"
                        class="form-control ">
                </div>
            </div>
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="product_description">Product
                    Description<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                    <input type="text" id="product_description" name="product_description" required="required"
                        class="form-control ">
                </div>
            </div>
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="ar_product_description">Product Arabic
                    Description<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                    <input type="text" id="ar_product_description" name="ar_product_description" required="required"
                        class="form-control ">
                </div>
            </div>
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="price">Price<span
                        class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                    <input type="text" id="price" name="price" required="required" class="form-control ">
                </div>
            </div>
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="img">Product Image<span
                        class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                    <input type="file" id="img" name="img" required="required" class="form-control ">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button class="btn btn-danger" type="reset">Reset</button>
                <button type="submit" class="btn btn-success">Save
                    changes</button>
            </div>
            </form>
        </div>
    </div>
</div>
</div>
</div>
</div>
<div class="title_right">
    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
        <div class="input-group">

            <input type="text" class="form-control" placeholder="Search for...">
            <span class="input-group-btn">
                <button class="btn btn-default" type="button">Go!</button>
            </span>
        </div>
    </div>
</div> --}}
</div>

<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                <div class="row">

                    <div class="col-md-12">

                        <div class="image view view-first">
                            <img style="width: 100%; display: block;"
                                src="{{asset('images\products\\').$product->img_path}}" alt="image" />
                        </div>
                        <br />
                        <div class="">
                            <p><strong>{{ $product->product_name }}</strong>
                            </p>

                            <p>{{ $product->product_description }}</p>
                            <div class="row">
                                @if(Session::get('user_role')=='Administrator'||Session::get('user_role')=='Restaurant
                                Admin')
                                <div class="x_content">
                                    <div class="row">
                                        <div class="col-md-12 text-center">

                                            <div class="item form-group">
                                                <div class="col-md-12 col-sm-12 text-left">
                                                    <div
                                                        class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                                                        <div class="input-group">
                                                            <button type="button" class="btn btn-round btn-success"
                                                                data-toggle="modal"
                                                                data-target=".bs-example-modal-lg"><i
                                                                    class="fa fa-plus-circle"></i> New
                                                                Item</button>

                                                            <div class="modal fade bs-example-modal-lg" tabindex="-1"
                                                                role="dialog" aria-hidden="true">
                                                                <div class="modal-dialog modal-lg">
                                                                    <div class="modal-content">

                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title" id="myModalLabel">
                                                                                New Item</h4>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal"><span
                                                                                    aria-hidden="true">×</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form id="create-menu"
                                                                                class="form-horizontal form-label-left"
                                                                                action="{{ Route('submenu-item.store') }}"
                                                                                method="POST"
                                                                                enctype="multipart/form-data">
                                                                                {{csrf_field()  }}

                                                                                <div class="item form-group">
                                                                                    <label
                                                                                        class="col-form-label col-md-3 col-sm-3 label-align"
                                                                                        for="item_name">Item
                                                                                        Name<span
                                                                                            class="required">*</span>
                                                                                    </label>
                                                                                    <div class="col-md-6 col-sm-6 ">
                                                                                        <input type="text"
                                                                                            id="item_name"
                                                                                            name="item_name"
                                                                                            required="required"
                                                                                            class="form-control ">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="item form-group">
                                                                                    <label
                                                                                        class="col-form-label col-md-3 col-sm-3 label-align"
                                                                                        for="ar_item_name">Arabic Item
                                                                                        Name<span
                                                                                            class="required">*</span>
                                                                                    </label>
                                                                                    <div class="col-md-6 col-sm-6 ">
                                                                                        <input type="text"
                                                                                            id="ar_item_name"
                                                                                            name="ar_item_name"
                                                                                            required="required"
                                                                                            class="form-control ">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="item form-group">
                                                                                    <label
                                                                                        class="col-form-label col-md-3 col-sm-3 label-align"
                                                                                        for="price">Price
                                                                                        <span class="required">*</span>
                                                                                    </label>
                                                                                    <div class="col-md-6 col-sm-6 ">
                                                                                        <input type="text" id="price"
                                                                                            name="price"
                                                                                            required="required"
                                                                                            class="form-control ">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="item form-group">
                                                                                    <label
                                                                                        class="col-form-label col-md-3 col-sm-3 label-align"
                                                                                        for="menu_name">Menu Name
                                                                                        <span class="required">*</span>
                                                                                    </label>
                                                                                    <div class="col-md-6 col-sm-6 ">
                                                                                        <select class="form-control"
                                                                                            id="menu_id" name="menu_id"
                                                                                            required="required">
                                                                                            @foreach($menus as $menu)
                                                                                            <option
                                                                                                value="{{$menu->id}}">
                                                                                                {{$menu->submenu_name}}
                                                                                            </option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                {{-- <input type="hidden" name="submenu_id" value="{{ $submenu->id }}">
                                                                                --}}


                                                                                <div class="modal-footer">
                                                                                    <button type="button"
                                                                                        class="btn btn-secondary"
                                                                                        data-dismiss="modal">Close</button>
                                                                                    <button class="btn btn-danger"
                                                                                        type="reset">Reset</button>
                                                                                    <button type="submit"
                                                                                        class="btn btn-success">Save
                                                                                        changes</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                                @endif
                                <!-- form input mask -->
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <form method="get" action="{{ Route('store_cart.store') }}"
                                        class="form-horizontal form-label-left">
                                        <input type="hidden" name="product_id" id="product_id"
                                            value="{{ $product->id }}">
                                        <input type="hidden" name="cat_id" id="cat_id"
                                            value="{{ $product->product_cat_id }}">

                                        {{ csrf_field() }}
                                        @foreach($menus as $menu)
                                        @if(App\Http\Controllers\SubmenuController::getSubmenuType($menu->id)==0)
                                        <div class="x_panel">
                                            <div class="x_title">
                                                <h2>{{ $menu->submenu_name }}</h2>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="x_content">
                                                <div class="form-group">
                                                    @foreach(App\Http\Controllers\SubmenuItemController::getItems($menu->id)
                                                    as $key => $item)
                                                    <label class="btn btn-default" data-toggle-class="btn-primary"
                                                        data-toggle-passive-class="btn-default">
                                                        <input type="radio" name="{{ $item->item_name }}" class="flat"
                                                            value="{{ $item->id }}">
                                                        &nbsp;{{ $item->item_name }}&nbsp; ( {{ $item->price }} )
                                                        <br />
                                                    </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                        <div class="x_panel">
                                            <div class="x_title">
                                                <h2>{{ $menu->submenu_name }}
                                                </h2>
                                                <div class="clearfix"></div>


                                            </div>
                                            <div class="x_content">
                                                <div class="form-group">
                                                    @foreach(App\Http\Controllers\SubmenuItemController::getItems($menu->id)
                                                    as $key => $item)
                                                    <label class="btn btn-default" data-toggle-class="btn-primary"
                                                        data-toggle-passive-class="btn-default">
                                                        <input type="checkbox" name="extra[]" id="hobby1"
                                                            value="{{ $item->id }}" data-parsley-mincheck="2"
                                                            class="flat" />
                                                        {{ $item->item_name }}
                                                    </label>
                                                    <br />
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @endforeach
                                        @if(Session::get('user_role')=='Anonymous')
                                        <script src='//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js'>
                                        </script>
                                        <script>
                                            $(function() {

                                          /* $(".numbers-row").append('<div class="inc button">+</div><div class="dec button">-</div>'); */

                                          $(".btn").on("click", function() {

                                            var $button = $(this);
                                            var oldValue = $button.parent().find("input").val();

                                            if ($button.text() == "+") {
                                          	  var newVal = parseFloat(oldValue) + 1;
                                          	} else {
                                        	   // Don't allow decrementing below zero
                                              if (oldValue > 0) {
                                                var newVal = parseFloat(oldValue) - 1;
                                        	    } else {
                                                newVal = 1;
                                              }
                                        	  }

                                            $button.parent().find("input").val(newVal);

                                          });

                                        });
                                        </script>
                                        <div class="x_panel">

                                            <div class="x_content text-center">
                                                <br />
                                                <div class="form-group">
                                                    <textarea name="notes" class="form-control" id="notes" value=""
                                                        placeholder="Add instructions (optional)"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="x_panel" style="align-content: center">

                                            <div class="x_content text-center">
                                                <br />

                                                <div>
                                                    <div class="btn btn-round btn-success">-</div>
                                                    <input class="text-center" style="border: none;" type="text"
                                                        size="2" name="quantity" id="quantity" value="1">
                                                    <div class="btn btn-round btn-success">+</div>
                                                </div>
                                                <button type="submit" class="btn btn-round btn-success">Add to
                                                    Cart</button>
                                                @endif
                                    </form>
                                </div>
                            </div>
                        </div>




                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
{{-- </div>
</div>
</div> --}}

@endsection
