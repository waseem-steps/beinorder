@extends('layouts.master')

@section('content')

<div class="right_col" role="main" style="background-color: #fff;">
    <div class="">
		<div class="page-title">
			<div class="title_left">
				<h3>Restaurant Administrator Settings</h3>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="row">
			<div class="col-md-12 col-sm-12 ">
				<div class="x_panel">
					<div class="x_title">
						<h2>Choose Your Preffered Options</h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<br>
						@if(Session::get('user_role')=='Restaurant Admin' || Session::get('user_role')=='Administrator')
							@if($settings->place_order_status == 0)
								<a href="{{Route('restaurant.enable_place_order',$settings->id)}}">
									<i class="fa fa-plus-circle fa-lg" aria-hidden="true"> Enable Place Order</i>
								</a>
							@endif
							@if($settings->place_order_status == 1)
								<a href="{{Route('restaurant.disable_place_order',$settings->id)}}">
									<i class="fa fa-minus-circle fa-lg" aria-hidden="true"> Disable Place Order</i>
								</a>
							@endif
							<br>
							@if($settings->table_code_status == 0)
								<a href="{{Route('restaurant.enable_table_code',$settings->id)}}">
									<i class="fa fa-plus-circle fa-lg" aria-hidden="true"> Enable Table Code</i>
								</a>
							@endif
							@if($settings->table_code_status == 1)
								<a href="{{Route('restaurant.disable_table_code',$settings->id)}}">
									<i class="fa fa-minus-circle fa-lg" aria-hidden="true"> Disable Table Code</i>
								</a>
							@endif
						@endif
					</div>
				</div>
			</div>
		</div>
    </div>
</div>

@endsection
