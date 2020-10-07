@extends('layouts.master')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_content">
                    <div class="row">

                        <div class="col-md-12">

                            <div class="image view view-first">
                                <img style="width: 100%; hieght:25%; display: block;"
                                    src="{{asset('images\products\\').$product->img_path}}" alt="image" />
                            </div>
                            <br />
                            <div class="">
                                <p><strong>{{ $product->product_name }}</strong> &nbsp;({{ $product->price }} {{ App\Http\Controllers\CountryController::getCurrency(Session::get('ip_rest'))}})
                                </p>
                                <p>{{ $product->product_description }}</p>
                                <div class="row">

                                    <!-- form input mask -->
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <form method="get" action="
                                        @if(App\Http\Controllers\SubmenuController::getSubmenu($product->id)==0)
                                        {{ Route('cart.store') }}
                                        @else
                                        {{ Route('store_cart.store') }}
                                        @endif"
                                        class="form-horizontal form-label-left">

                                            <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="product_price" id="product_price" value="{{ $product->price }}">
                                            <input type="hidden" name="cat_id" id="cat_id" value="{{ $product->product_cat_id }}">

                                            {{ csrf_field() }}
                                            @foreach(App\Http\Controllers\SubmenuController::getSubmenus($product->id) as $menu)
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
                                                            <input type="radio" checked name="{{ $item->submenu_id }}" id="{{ $item->submenu_id }}" class="flat" value="{{ $item->id }}">
                                                            &nbsp;{{ $item->item_name }}&nbsp; ( {{ $item->price }} &nbsp;{{ App\Http\Controllers\CountryController::getCurrency(Session::get('ip_rest')) }})
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
                                                            <input type="checkbox"  name="extra[]" id="extra" value="{{ $item->id }}"
                                                                data-parsley-mincheck="2" class="flat" />
                                                           {{ $item->id }} {{ $item->item_name }} &nbsp;({{ $item->price }} {{ App\Http\Controllers\CountryController::getCurrency(Session::get('ip_rest'))}})
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
                                                                              }
                                                                              else if ($button.text() == "-"){
if (oldValue > 0) {
var newVal = parseFloat(oldValue) - 1;
} else {
newVal = 1;
}
                                                                              }

                                                                              else {
                                                                        	   // Don't allow decrementing below zero
                                                                            newVal=oldValue;
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
                                                        <input class="text-center" style="border: none;" type="text" size="2" name="quantity"
                                                            id="quantity" value="1">
                                                        <div class="btn btn-round btn-success">+</div>
                                                    </div>
                                                    <button type="submit" class="btn btn-round btn-success">Add to
                                                        Cart</button>
                                                    @endif
                                        </form>
                                    </div>
                                </div>
                                @if(Session::get('user_role')=='Administrator'||Session::get('user_role')=='Restaurant Admin')
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
                                                                Menu</button>
                                                            <div class="modal fade bs-example-modal-lg" tabindex="-1"
                                                                role="dialog" aria-hidden="true">
                                                                <div class="modal-dialog modal-lg">
                                                                    <div class="modal-content">

                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title" id="myModalLabel">
                                                                                New Menu</h4>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal"><span
                                                                                    aria-hidden="true">×</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form id="create-menu"
                                                                                class="form-horizontal form-label-left"
                                                                                action="{{ Route('submenu.store')}}"
                                                                                method="POST">
                                                                                {{csrf_field()  }}

                                                                                <div class="item form-group">
                                                                                    <label
                                                                                        class="col-form-label col-md-3 col-sm-3 label-align"
                                                                                        for="menu_name">Menu
                                                                                        Name<span
                                                                                            class="required">*</span>
                                                                                    </label>
                                                                                    <div class="col-md-6 col-sm-6 ">
                                                                                        <input type="text"
                                                                                            id="menu_name"
                                                                                            name="menu_name"
                                                                                            required="required"
                                                                                            class="form-control ">
                                                                                    </div>
                                                                                </div>
                                                                                <input type="hidden" name="product_id"
                                                                                    value="{{ $product->id }}">
                                                                                <div class="item form-group">
                                                                                    <label
                                                                                        class="col-form-label col-md-3 col-sm-3 label-align"
                                                                                        for="ar_menu_name">Menu
                                                                                        Arabic Name<span
                                                                                            class="required">*</span>
                                                                                    </label>
                                                                                    <div class="col-md-6 col-sm-6 ">
                                                                                        <input type="text"
                                                                                            id="ar_menu_name"
                                                                                            name="ar_menu_name"
                                                                                            required="required"
                                                                                            class="form-control ">
                                                                                    </div>
                                                                                </div>

                                                                                <div class="item form-group">
                                                                                    <label
                                                                                        class="col-form-label col-md-3 col-sm-3 label-align"
                                                                                        for="ar_menu_name">Menu
                                                                                        Type<span
                                                                                            class="required">*</span>
                                                                                    </label>
                                                                                    <div class="col-md-6 col-sm-6 ">
                                                                                        <input type="radio"
                                                                                            name="menu_type"
                                                                                            class="flat" value="0">
                                                                                        Single
                                                                                        <input type="radio"
                                                                                            name="menu_type"
                                                                                            class="flat" value="1">
                                                                                        Multiple
                                                                                    </div>
                                                                                </div>

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
                                                            <div class="input-group">
                                                                <button type="button" class="btn btn-round btn-success" data-toggle="modal" data-target=".bs-example-modal-lg12"><i
                                                                        class="fa fa-plus-circle"></i> New
                                                                    Item</button>

                                                                <div class="modal fade bs-example-modal-lg12" tabindex="-1" role="dialog" aria-hidden="true">
                                                                    <div class="modal-dialog modal-lg">
                                                                        <div class="modal-content">

                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title" id="myModalLabel">
                                                                                    New Item</h4>
                                                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <form id="create-menu" class="form-horizontal form-label-left"
                                                                                    action="{{ Route('submenu-item.store') }}" method="POST" enctype="multipart/form-data">
                                                                                    {{csrf_field()  }}
                                                                                    <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">
                                                                                    <div class="item form-group">
                                                                                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="item_name">Item
                                                                                            Name<span class="required">*</span>
                                                                                        </label>
                                                                                        <div class="col-md-6 col-sm-6 ">
                                                                                            <input type="text" id="item_name" name="item_name" required="required"
                                                                                                class="form-control ">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="item form-group">
                                                                                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="ar_item_name">Arabic Item
                                                                                            Name<span class="required">*</span>
                                                                                        </label>
                                                                                        <div class="col-md-6 col-sm-6 ">
                                                                                            <input type="text" id="ar_item_name" name="ar_item_name" required="required"
                                                                                                class="form-control ">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="item form-group">
                                                                                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="price">Price
                                                                                            <span class="required">*</span>
                                                                                        </label>
                                                                                        <div class="col-md-6 col-sm-6 ">
                                                                                            <input type="text" id="price" name="price" required="required" class="form-control ">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="item form-group">
                                                                                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="menu_name">Menu Name
                                                                                            <span class="required">*</span>
                                                                                        </label>
                                                                                        <div class="col-md-6 col-sm-6 ">
                                                                                            <select class="form-control" id="menu_id" name="menu_id" required="required">
                                                                                                @foreach(App\Http\Controllers\SubmenuController::getSubmenus($product->id) as $menu)
                                                                                                <option value="{{$menu->id}}">
                                                                                                    {{$menu->submenu_name}}
                                                                                                </option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    {{-- <input type="hidden" name="submenu_id" value="{{ $submenu->id }}">
                                                                                    --}}


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
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if(Session::get('user_role')=='Anonymous')
                                @if(App\Http\Controllers\CartController::getTotalCarts(Session::get('ip_address'))>0)
                                <div class="x_panel">
                                    <div class="x_content">
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <a class="btn btn-success form-control" href="{{ Route('cart.active-cart') }}">
                                                    {{ App\Http\Controllers\CartController::getTotalCarts(Session::get('ip_address')) }}&nbsp;<i
                                                        class="fa fa-shopping-cart"></i>&nbsp;|&nbsp;
                                                    Review Order&nbsp;|

                                                    {{ App\Http\Controllers\CartController::getTotalAmount(Session::get('ip_address'))}}&nbsp;{{ App\Http\Controllers\CountryController::getCurrency(Session::get('ip_rest')) }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @endif
                               {{--  <div class="row">
                                    <!-- form input mask -->
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <form method="get" action="{{ Route('product_cart.store') }}"
                                            class="form-horizontal form-label-left">
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="price" value="{{ $product->price }}">
                                            <input type="hidden" name="cat_id" value="{{ $product->product_cat_id }}">

                                            {{ csrf_field() }}
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
                                              	}
                                                else if ($button.text() == "-") {
                                                      {
                                                    // Don't allow decrementing below zero
                                                    if (oldValue > 0) {
                                                    var newVal = parseFloat(oldValue) - 1;
                                                    } else {
                                                    newVal = 1;
                                                    }
                                                    }
                                                }
                                                else newVal = parseFloat(oldValue);
                                                $button.parent().find("input").val(newVal);
                                              });

                                            });
                                            </script>
                                            <div class="x_panel text-center">

                                                <div class="x_content">
                                                    <br />
                                                    <div class="form-group">
                                                        <textarea name="notes" class="form-control" id="notes" value=""
                                                            placeholder="Add instructions (optional)"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="x_panel text-center">

                                                <div class="x_content">
                                                    <br />
                                                    <div>
                                                        <div class="btn btn-round btn-success">-</div>
                                                        <input class="text-center" style="border: none;" type="text"
                                                            size="2" name="quantity" id="quantity" value="1">
                                                        <div class="btn btn-round btn-success">+</div>
                                                    </div>
                                                    <button type="submit" class="btn btn-round btn-success">Add to
                                                        Cart</button>
                                                </div>
                                            </div>
                                            @endif
                                        </form>
                                    </div>
                                </div> --}}
                            </div>




                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection
