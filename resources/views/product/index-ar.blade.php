@extends('layouts.master')

@section('content')

<!-- page content -->
<div class="right_col" role="main" style="background-color: #fff;">
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12">
			<div class="x_panel" style="border: 0px;">
				<div class="x_content">
					<div class="row">
						@foreach ($products as $product)
							<div class="col-md-55">
								<div class="well profile_view" style="padding: 10px; border-radius: 15px; border-color: #093120; border-width: 2px;">
									<a href="{{ Route('product.details',$product->id)}}">
										<div class="profile_img">
											<img 	class="img-responsive avatar-view"
													style="width: 100%; border-top-left-radius: 15px; border-top-right-radius: 15px; border-bottom-left-radius: 0px; border-bottom-right-radius: 0px;"
													src="{{asset('images\products\thumbnails\\').$product->thumbnail_path}}"
													alt="image"
													title="{{ $product->product_name }}"/>
										</div>
										<div class="caption" style="height: 70px; border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;">
											<p><strong>{{ $product->product_name }}</strong></p>
											<p>{{ $product->price }}
												{{ App\Http\Controllers\CountryController::getCurrencyByProduct($product->id) }}
												@if(App\Http\Controllers\CartController::getTotalCart($product->id,
												Session::get('ip_address') )>0)
												x
												{{ App\Http\Controllers\CartController::getTotalCart($product->id,Session::get('ip_address') ) }}
												@endif
											</p>
										</div>
										@if(Session::get('user_role')=='Administrator'||Session::get('user_role')=='Restaurant Admin')
											<div>
												<p>
													<a data-toggle="tooltip" data-placement="bottom" title="Edit" href="{{ Route('product.edit',$product->id) }}"><i
															class="fa fa-edit fa-2x"></i></a>
													<a onclick="return confirm('Are you sure you want to delete this item?');" data-toggle="tooltip"
														data-placement="bottom" title="Delete" href="{{Route('product.delete',$product->id)}}"><i
															class="fa fa-remove fa-2x"></i></a>
													@if($product->status ==1)
													<a data-toggle="tooltip" data-placement="bottom" title="Lock" href="{{ Route('product.lock',$product->id) }}"><i
															class="fa fa-lock fa-2x"></i></a>
													@else
													<a data-toggle="tooltip" data-placement="bottom" title="Unlock" href="{{ Route('product.unlock',$product->id) }}"><i
															class="fa fa-unlock fa-2x"></i></a>
													@endif
												</p>
											</div>
										@endif
									</a>
								</div>
							</div>
						@endforeach
						@if(Session::get('user_role')=='Administrator'||Session::get('user_role')=='Restaurant Admin')
							<div class="col-md-55">
								<div class="well profile_view" style="padding: 10px; border-radius: 15px; border-color: #093120; border-width: 2px;">
									<div class="input-group">
										<a class="btn btn-round btn-success" href="{{ Route('product.create',['cat_id'=>$cat_id]) }}"><i
												class="fa fa-plus-circle"></i> منتج جديد</a>
									</div>
								</div>
							</div>
						@endif
					</div>
				</div>
			</div>
			@if(Session::get('user_role')=='Anonymous')
				@if(App\Http\Controllers\CartController::getTotalCarts(Session::get('ip_address'))>0)
				<div class="x_panel">
					<div class="x_content">
						<div class="row">
							<div class="col-md-12 text-center">
								<a class="btn btn-success form-control" href="{{ Route('cart.active-cart') }}">
									{{ App\Http\Controllers\CartController::getTotalCarts(Session::get('ip_address')) }}&nbsp;<i
										class="fa fa-shopping-cart"></i>&nbsp;|&nbsp;
									مراجعة الطلب&nbsp;|

									{{ number_format(App\Http\Controllers\CartController::getTotalAmount(Session::get('ip_address')), 3, '.', '')}}&nbsp;{{ App\Http\Controllers\CountryController::getCurrency($rest_id) }}</a>
							</div>
						</div>
					</div>
				</div>
				@endif
			@endif
		</div>
	</div>
</div>
@endsection
