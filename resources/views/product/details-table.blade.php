@extends('layouts.master')

@section('content')
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="image">
                    <img style="width: 100%; hieght:150px; display: block;"
                        src="{{asset('images\products\\').$product->img_path}}" alt="image" />
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <br />
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <p><strong>{{ $product->product_name }}</strong> &nbsp;({{ $product->price }}
                    {{ App\Http\Controllers\CountryController::getCurrency(Session::get('rest_id'))}})
                </p>
            </div>
            <div class="col-md-12 col-sm-12 ">
                <p>{{ $product->product_description }}</p>
            </div>
			
            <div class="col-md-12 col-sm-12 ">
				@if (session('status'))
                        <div class="alert alert-danger mt-5">
                            {{ session('status') }}
                        </div>
                @endif
                <form
				method="get"
				action="
					@if($rest->table_code_status == 1)
						{{ Route('table.product-categories') }}
					@else
						{{ Route('cart.checkout-table') }}
					@endif"
					class="form-horizontal form-label-left">
                    <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="product_price" id="product_price" value="{{ $product->price }}">
                    <input type="hidden" name="cat_id" id="cat_id" value="{{ $product->product_cat_id }}">
                    <input type="hidden" name="rest_id" id="rest_id" value="{{ Session::get('rest_id') }}">
                    <input type="hidden" name="table_id" id="table_id" value="{{ $table_id }}">
                    {{ csrf_field() }}
                    @foreach(App\Http\Controllers\SubmenuController::getSubmenus($product->id) as $menu)
                    @if(App\Http\Controllers\SubmenuController::getSubmenuType($menu->id)==0)
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>{{ $menu->submenu_name }}</h2>
                            @if(Session::get('user_role')!='Anonymous')
                            <a onclick="return confirm('Are you sure you want to delete this item?');"
                                class="btn btn-danger" href="{{ Route('submenu.delete',$menu->id) }}"><i
                                    class="fa fa-remove"></i></a>
                            @endif
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="form-group">
                                @foreach(App\Http\Controllers\SubmenuItemController::getItems($menu->id)
                                as $key => $item)

                                <input type="radio" name="{{ $item->submenu_id }}" id="{{ $item->id }}"
                                    value="{{ $item->id }}" checked>
                                &nbsp;{{ $item->item_name }}&nbsp; ( {{ $item->price }}
                                &nbsp;{{ App\Http\Controllers\CountryController::getCurrency(Session::get('rest_id')) }})
                                @if(Session::get('user_role')!='Anonymous')
                                <a onclick="return confirm('Are you sure you want to delete this item?');"
                                    class="btn btn-danger" href="{{ Route('submenu-item.delete',$item->id) }}"><i
                                        class="fa fa-remove"></i></a>
                                @endif
                                <br />

                                @endforeach
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>{{ $menu->submenu_name }}
                            </h2>
                            @if(Session::get('user_role')!='Anonymous')
                            <a onclick="return confirm('Are you sure you want to delete this item?');"
                                class="btn btn-danger" href="{{ Route('submenu.delete',$menu->id) }}"><i
                                    class="fa fa-remove"></i></a>
                            @endif
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="form-group">
                                @foreach(App\Http\Controllers\SubmenuItemController::getItems($menu->id)
                                as $key => $item)
                                <input type="hidden" id="id{{ $item->id }}" name="test[]" value="-1">

                                <input type="checkbox" onclick="myFunction({{ $item->id }})" name="extra[]"
                                    id="{{ $item->id }}" value="{{ $item->id }}" />

                                {{ $item->item_name }} &nbsp;({{ $item->price }}

                                ({{ App\Http\Controllers\CountryController::getCurrency(Session::get('rest_id'))}})
                                @if(Session::get('user_role')!='Anonymous')
                                <a onclick="return confirm('Are you sure you want to delete this item?');"
                                    class="btn btn-danger" href="{{ Route('submenu-item.delete',$item->id) }}"><i
                                        class="fa fa-remove"></i></a>
                                @endif
                                </label>
                                <br />
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                    @if(Session::get('user_role')=='Anonymous')
						@if($rest->place_order_status == 1)
							<script src='//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js'></script>
							<script>
								$(function() {
									$(".btn").on("click", function() {
									var $button = $(this);
									var oldValue = $button.parent().find("input").val();
									if ($button.text() == "+") {var newVal = parseFloat(oldValue) + 1;}
									else if ($button.text() == "-"){
										if (oldValue > 0) {var newVal = parseFloat(oldValue) - 1;}
										else {newVal = 1;}
									}
									else {// Don't allow decrementing below zero
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
									<div>
										<div class="btn btn-round btn-success">-</div>
										<input class="text-center" style="border: none;" type="text" size="2" name="quantity" id="quantity" value="1">
										<div class="btn btn-round btn-success">+</div>
									</div>
									<!-- Table Code Disabled -->
									@if($rest->table_code_status == 0)
										<button type="submit" class="btn btn-round btn-success" onClick="this.form.submit(); this.disabled=true;">Place Order</button>
									@endif
									<!-- Table Code Enabled -->
									@if($rest->table_code_status == 1)
										<button type="button" class="btn btn-round btn-success" data-toggle="modal" data-target=".bs-example-modal-lg">Place Order</button>
									
										<!-- //////////////////////////////////////////////////////////////////////////// -->
										<div 	class="modal fade bs-example-modal-lg"
													tabindex="-1"
													role="dialog"
													aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="myModalLabel">Please Enter Your Table Code ...</h4>
                                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                                                        </div>
                                                        <div class="modal-body">
																<div class="item form-group">
																	<label class="col-form-label col-md-3 col-sm-3 label-align" for="table_code">Table Code<span class="required">*</span>
																	</label>
																	<div class="col-md-6 col-sm-6 ">
																		<input type="text" id="table_code" name="table_code" required="required" class="form-control ">
																	</div>
																</div>
																<button type="submit" class="btn btn-round btn-success" onClick="this.form.submit(); this.disabled=true;">Place Order</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
										<!-- ///////////////////////////////////////////////////////////////////////////////// -->
									@endif
								</div>
							</div>
						@endif
					@endif
                </form>
				
                @if(Session::get('user_role')=='Administrator'||Session::get('user_role')=='Restaurant Admin')
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div class="item form-group">
                                <div class="col-md-12 col-sm-12 text-left">
                                    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                                        <div class="input-group">
                                            <button type="button"
													class="btn btn-round btn-success" 
													data-toggle="modal"
													data-target=".bs-example-modal-lg"><i class="fa fa-plus-circle"></i>New Menu</button>
                                            <div 	class="modal fade bs-example-modal-lg"
													tabindex="-1"
													role="dialog"
													aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="myModalLabel">New Menu</h4>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal"><span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form id="create-menu"
                                                                class="form-horizontal form-label-left"
                                                                action="{{ Route('submenu.store')}}" method="POST">
                                                                {{csrf_field()  }}

                                                                <div class="item form-group">
                                                                    <label
                                                                        class="col-form-label col-md-3 col-sm-3 label-align"
                                                                        for="menu_name">Menu Name<span class="required">*</span>
                                                                    </label>
                                                                    <div class="col-md-6 col-sm-6 ">
                                                                        <input type="text" id="menu_name"
                                                                            name="menu_name" required="required"
                                                                            class="form-control ">
                                                                    </div>
                                                                </div>
                                                                <input type="hidden" name="product_id"
                                                                    value="{{ $product->id }}">
                                                                <div class="item form-group">
                                                                    <label
                                                                        class="col-form-label col-md-3 col-sm-3 label-align"
                                                                        for="ar_menu_name">Menu
                                                                        Arabic Name<span class="required">*</span>
                                                                    </label>
                                                                    <div class="col-md-6 col-sm-6 ">
                                                                        <input type="text" id="ar_menu_name"
                                                                            name="ar_menu_name" required="required"
                                                                            class="form-control ">
                                                                    </div>
                                                                </div>

                                                                <div class="item form-group">
                                                                    <label
                                                                        class="col-form-label col-md-3 col-sm-3 label-align"
                                                                        for="ar_menu_name">Menu
                                                                        Type<span class="required">*</span>
                                                                    </label>
                                                                    <div class="col-md-6 col-sm-6 ">
                                                                        <input type="radio" name="menu_type"
                                                                            class="flat" value="0" checked>
                                                                        Single
                                                                        <input type="radio" name="menu_type"
                                                                            class="flat" value="1">
                                                                        Multiple
                                                                    </div>
                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Close</button>
                                                                    <button class="btn btn-danger"
                                                                        type="reset">Reset</button>
                                                                    <button type="submit" class="btn btn-success">Save
                                                                        changes</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="input-group">
                                                <button type="button" class="btn btn-round btn-success"
                                                    data-toggle="modal" data-target=".bs-example-modal-lg12"><i
                                                        class="fa fa-plus-circle"></i> New
                                                    Item</button>

                                                <div class="modal fade bs-example-modal-lg12" tabindex="-1"
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
                                                                    method="POST" enctype="multipart/form-data">
                                                                    {{csrf_field()  }}
                                                                    <input type="hidden" name="product_id"
                                                                        id="product_id" value="{{ $product->id }}">
                                                                    <div class="item form-group">
                                                                        <label
                                                                            class="col-form-label col-md-3 col-sm-3 label-align"
                                                                            for="item_name">Item
                                                                            Name<span class="required">*</span>
                                                                        </label>
                                                                        <div class="col-md-6 col-sm-6 ">
                                                                            <input type="text" id="item_name"
                                                                                name="item_name" required="required"
                                                                                class="form-control ">
                                                                        </div>
                                                                    </div>
                                                                    <div class="item form-group">
                                                                        <label
                                                                            class="col-form-label col-md-3 col-sm-3 label-align"
                                                                            for="ar_item_name">Arabic Item
                                                                            Name<span class="required">*</span>
                                                                        </label>
                                                                        <div class="col-md-6 col-sm-6 ">
                                                                            <input type="text" id="ar_item_name"
                                                                                name="ar_item_name" required="required"
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
                                                                            <input type="text" id="price" name="price"
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
                                                                            <select class="form-control" id="menu_id"
                                                                                name="menu_id" required="required">
                                                                                @foreach(App\Http\Controllers\SubmenuController::getSubmenus($product->id)
                                                                                as $menu)
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
                                                                        <button type="button" class="btn btn-secondary"
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
                </div>
                @endif

            </div>
        </div>
    </div>
</div>
<script>
    function myFunction(id) {
  var checkBox = document.getElementById(id);
  var text = document.getElementById("id"+id);
  if (checkBox.checked == true){
    text.value=id;
  } else {
     text.value="-1";
  }
}
</script>

<!-- /page content -->
@endsection
