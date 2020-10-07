@extends('layouts.master')

@section('content')
<!-- page content -->
<div class="right_col" role="main" style="background-color: #fff;">
	@if(Session::get('user_role')=='Administrator'||Session::get('user_role')=='Restaurant Admin')
		<div class="row">
            <div class="col-md-12">
                <div class="x_panel" style="border: 0px;">
                    <div class="x_content">
                        <div class="row">
                            @foreach ($rests as $rest)
								<div class="col-md-55">
									<div 	class="well profile_view"
											style="padding: 10px; border-radius: 15px; border-color: #093120; border-width: 2px;">
										<!-- External Restaurants -->
										@if(App\Http\Controllers\PricePlanController::getPlanTypeByRest($rest->id) == 0)
											<a href="{{ Route('product-categories.rest-cat',$rest->id)}}">
										@endif
										<!-- Internal Restaurants -->
										@if(App\Http\Controllers\PricePlanController::getPlanTypeByRest($rest->id) == 1)
											<a href="{{ Route('product-categories.rest-cat-table',$rest->id)}}">
										@endif
											<div class="profile_img">
												<img 	class="img-responsive avatar-view" 
														style="width: 100%; border-top-left-radius: 15px; border-top-right-radius: 15px; border-bottom-left-radius: 0px; border-bottom-right-radius: 0px;"
														src="{{asset('images\restaurants\\').$rest->logo}}" 
														alt="image" 
														title="{{ $rest->rest_name }}"/>
											</div>
											
											<div 	class="caption" 
													style="height: 70px; border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;">
												<p><strong>{{ $rest->rest_name }}</strong></p>
												<p>{{ $rest->description }}</p>
											</div>
											
											<div>
												<p>
													@if($rest->status ==1)
														<a 	data-toggle="tooltip" data-placement="bottom" 
															title="Lock"
															href="{{ Route('restaurant.lock',$rest->id) }}">
															<i class="fa fa-lock fa-2x"></i>
														</a>
													@else
														<a 	data-toggle="tooltip" data-placement="bottom"
															title="Unlock"
															href="{{ Route('restaurant.unlock',$rest->id) }}">
															<i class="fa fa-unlock fa-2x"></i>
														</a>
													@endif
													
													<!-- External Restaurants -->
													@if(App\Http\Controllers\PricePlanController::getPlanTypeByRest($rest->id) == 0)
														<a data-toggle="tooltip" data-placement="bottom"
															title="Branch Management"
															href="{{ Route('branches.index',$rest->id) }}"><i
															class="fa fa-sitemap fa-2x"></i></a>
													@endif
													
													<!-- Internal Restaurants -->
													@if(App\Http\Controllers\PricePlanController::getPlanTypeByRest($rest->id) == 1)
														<a data-toggle="tooltip" data-placement="bottom"
															title="Table Management"
															href="{{Route('table.index',$rest->id)}}"><i
															class="fa fa-sitemap fa-2x"></i></a>
													@endif
													
													<a 	data-toggle="tooltip" data-placement="bottom"
														title="Admin Settings"
														href="{{Route('restaurant.admin_settings',$rest->id)}}">
														<i class="fa fa-cogs fa-2x"></i></a>
													
													<a 	data-toggle="tooltip" data-placement="bottom" 
														title="Edit"
														href="{{ Route('restaurant.edit',$rest->id) }}">
														<i class="fa fa-edit fa-2x"></i></a>
												</p>
											</div>
										</a>
									</div>
								</div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
	@endif
</div>
@endsection
