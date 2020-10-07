@extends('layouts.master-ar')
@section('content')
<!-- page content -->
<div class="right_col" role="main" style="background-color: #fff;">
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="image">
                <img style="width: 100%; display: block;" src="{{asset('images\restaurants\\').$rest->logo}}" />
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
                            <div 	class="well profile_view"
									style="padding: 10px; border-radius: 15px; border-color: #093120; border-width: 2px;">
                                <a href="{{ Route('products.index',$cat->id)}}">
                                    <div 	class="profile_img">
                                        <img 	class="img-responsive avatar-view"
												style="width: 100%; border-radius: 15px;"
												src="{{asset('images\product_categories\thumbnails\\').$cat->thumbnail_path}}"
												alt="image"
												title="{{ $cat->ar_category_name }}" />
                                    </div>
                                    <div 	class="caption"
											style="height: 30px; border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;">
                                        <p><strong>{{ $cat->ar_category_name }}</strong></p>
                                    </div>
                                    @if(Session::get('user_role')=='Administrator'||Session::get('user_role')=='Restaurant Admin')
                                    <div>
                                        <p>
                                            <a data-toggle="tooltip" data-placement="bottom" title="تعديل"
                                                href="{{ Route('product-category.edit-ar',$cat->id) }}"><i
                                                    class="fa fa-edit fa-2x"></i>
                                            </a>
                                            <a onclick="return confirm('هل أنت متأكد من حذف العنصر؟?');"
                                                data-toggle="tooltip" data-placement="bottom" title="حذف"
                                                href="{{Route('product-category.delete-ar',$cat->id)}}"><i
                                                    class="fa fa-remove fa-2x"></i>
                                            </a>
                                        </p>
                                    </div>
                                    @endif
                                </a>
                            </div>
                        </div>
                        @endforeach
                        @if(Session::get('user_role')=='Administrator'||Session::get('user_role')=='Restaurant Admin')
                        <div class="col-md-55">
                            <div class="well profile_view"
                                style="padding: 10px; border-radius: 15px; border-color: #093120; border-width: 2px;">
                                <a type="button" class="btn btn-round btn-success"
                                    href="{{Route('product-categories.create-ar',['rest_id'=>$rest_id])}}">
                                    {{--    data-toggle="modal" data-modal-id="modal1"
                                                            data-target=".bs-example-modal-lg"> --}}
                                    <i class="fa fa-plus-circle"></i> إضافة نوع منتج</a>
                                <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
                                    aria-hidden="true" id="modal1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">نوع منتج جديد</h4>
                                                <button type="button" class="close" data-dismiss="modal"><span
                                                        aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="create-product-category" data-parsley-validate
                                                    class="form-horizontal form-label-left" action="#"
                                                    {{-- "{{ Route('product-category.store',$rest_id) }}" --}}
                                                    method="POST" enctype="multipart/form-data">
                                                    {{csrf_field()  }}
                                                    <input type="hidden" name="rest_id" id="rest_id"
                                                        value="{{ $rest_id }}" />
                                                    <div class="item form-group">
                                                        <label class="col-form-label col-md-3 col-sm-3 label-align"
                                                            for="cat_name">اسم نوع المنتج<span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 ">
                                                            <input type="text" id="cat_name" name="cat_name"
                                                                required="required" class="form-control ">
                                                        </div>
                                                    </div>
                                                    <div class="item form-group">
                                                        <label class="col-form-label col-md-3 col-sm-3 label-align"
                                                            for="ar_cat_name">الاسم العربي<span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 ">
                                                            <input type="text" id="ar_cat_name" name="ar_cat_name"
                                                                required="required" class="form-control ">
                                                        </div>
                                                    </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">إغلاق</button>
                                            <button class="btn btn-danger" type="reset">محي</button>
                                            <button type="submit" class="btn btn-success">حفظ التغيرات</button>
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
    </div>
    @if(Session::get('user_role')=='Anonymous')
    @if(App\Http\Controllers\CartController::getTotalCarts(Session::get('ip_address'))>0)
    <div class="x_panel">
        <div class="x_content">
            <div class="row">
                <div class="col-md-12 text-center">
                    <a class="btn btn-success form-control" href="{{ Route('cart.active-cart-ar') }}">
                        {{ App\Http\Controllers\CartController::getTotalCarts(Session::get('ip_address')) }}&nbsp;<i
                            class="fa fa-shopping-cart"></i>&nbsp;|&nbsp;
                        مراجعة الطلب&nbsp;|
                        {{ App\Http\Controllers\CartController::getTotalAmount(Session::get('ip_address')) }}&nbsp;
                        {{ App\Http\Controllers\CountryController::getCurrency(Session::get('rest_id')) }}</a>
                </div>
            </div>
        </div>
    </div>
    @endif
    @endif
</div>
</div>
</div>

<!-- /page content -->
@endsection
