@extends('layouts.master')

@section('content')
<!-- page content -->
<div class="right_col" role="main" style="background-color: #fff;">
    <div class="">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="image">
                    <img style="width: 100%; hieght:150px; display: block;"
                        src="{{asset('images\restaurants\\').$rest->logo}}" />
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <br />
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <strong>{{ $rest->rest_name }}</strong>
            </div>
            <div class="col-md-12 col-sm-12 ">
                <p>{{ $rest->description }}</p>
            </div>
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel" style="border: 0px;">
                    <div class="x_content">
                        <div class="row">
                            @foreach ($cats as $cat)
                            <div class="col-md-55">
							<div class="well profile_view" style="padding: 10px; border-radius: 15px; border-color: #093120; border-width: 2px;">
                                <a href="{{ Route('products.table-index',['id'=>$cat->id,'rest_id'=>$rest_id,'table_id'=>$table_id])}}">
                                    <div class="profile_img">
                                            <img class="img-responsive avatar-view" style="width: 100%; border-top-left-radius: 15px; border-top-right-radius: 15px; border-bottom-left-radius: 0px; border-bottom-right-radius: 0px;"
                                                src="{{asset('images\product_categories\thumbnails\\').$cat->thumbnail_path}}"
                                                alt="image" />
												</div>
                                        <div class="caption" style="height: 40px; border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;">
                                            <p><strong>{{ $cat->category_name }}</strong></p>
											</div>

                                            @if(Session::get('user_role')=='Administrator'||Session::get('user_role')=='Restaurant
                                            Admin')
											<div>
                                            <p>
                                                <a data-toggle="tooltip" data-placement="bottom" title="Edit"
                                                    href="{{ Route('product-category.edit',$cat->id) }}"><i
                                                        class="fa fa-edit"></i></a>
                                                <a onclick="return confirm('Are you sure you want to delete this item?');"
                                                    data-toggle="tooltip" data-placement="bottom" title="Delete"
                                                    href="{{Route('product-category.delete',$cat->id)}}"><i
                                                        class="fa fa-remove"></i></a></p>
														</div>
                                            @endif



                                </a>
								</div>
                            </div>
                            @endforeach






							@if(Session::get('user_role')=='Administrator'||Session::get('user_role')=='Restaurant
							Admin')
							<div class="col-md-55">
							<div class="well profile_view">

								<div class="input-group">
									<button type="button" class="btn btn-round btn-success"
										data-toggle="modal" data-modal-id="modal1"
										data-target=".bs-example-modal-lg"><i
											class="fa fa-plus-circle"></i>
										نوع منتج جديد</button>
									<div class="modal fade bs-example-modal-lg" tabindex="-1"
										role="dialog" aria-hidden="true" id="modal1">
										<div class="modal-dialog modal-lg">
											<div class="modal-content">

												<div class="modal-header">
													<h4 class="modal-title" id="myModalLabel">نوع منتج جديد</h4>
													<button type="button" class="close"
														data-dismiss="modal"><span
															aria-hidden="true">×</span>
													</button>
												</div>
												<div class="modal-body">
													<form id="create-product-category"
														data-parsley-validate
														class="form-horizontal form-label-left"
														action="{{ Route('product-category.store',$rest_id) }}"
														method="POST" enctype="multipart/form-data">
														{{csrf_field()  }}
														<input type="hidden" name="rest_id"
															id="rest_id" value="{{ $rest_id }}" />
														<div class="item form-group">
															<label
																class="col-form-label col-md-3 col-sm-3 label-align"
																for="cat_name">اسم نوع املمنتج<span class="required">*</span>
															</label>
															<div class="col-md-6 col-sm-6 ">
																<input type="text" id="cat_name"
																	name="cat_name"
																	required="required"
																	class="form-control ">
															</div>
														</div>
														<div class="item form-group">
															<label
																class="col-form-label col-md-3 col-sm-3 label-align"
																for="ar_cat_name">الاسم العربي<span class="required">*</span>
															</label>
															<div class="col-md-6 col-sm-6 ">
																<input type="text" id="ar_cat_name"
																	name="ar_cat_name"
																	required="required"
																	class="form-control ">
															</div>
														</div>
														<div class="item form-group">
															<label
																class="col-form-label col-md-3 col-sm-3 label-align"
																for="img">الصورة<span class="required">*</span>
															</label>
															<div class="col-md-6 col-sm-6 ">
																<input type="file" id="img"
																	name="img" required="required"
																	class="form-control ">
															</div>
														</div>

														<div class="modal-footer">
															<button type="button"
																class="btn btn-secondary"
																data-dismiss="modal">إغلاق</button>
															<button class="btn btn-danger"
																type="reset">محي</button>
															<button type="submit"
																class="btn btn-success">حفظ التغيرات</button>
														</div>
													</form>
												</div>
											</div>
										</div>
									</div>
								</div>

							</div>
							</div>
							@endif

                        </div>
                        {{-- @endif --}}
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
                                    {{ App\Http\Controllers\CartController::getTotalAmount(Session::get('ip_address')) }}&nbsp;
                                    {{ App\Http\Controllers\CountryController::getCurrency(Session::get('ip_rest')) }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @endif
            </div>
        </div>
    </div>
</div>
<!-- /page content -->
@endsection
