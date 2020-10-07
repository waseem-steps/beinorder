@extends('layouts.master-ar')

@section('content')
<!-- page content -->
<div class="right_col" role="main" style="background-color: #fff;">
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="image">
                <img style=" width:100%; display: block;" src="{{asset('images\restaurants\\').$rest->logo}}" />
            </div>
        </div>
    </div>
    {{-- <div class="clearfix"></div> --}}
    <br />
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <strong>{{ $rest->ar_rest_name }}</strong>
        </div>
        <div class="col-md-12 col-sm-12 ">
            <p>{{ $rest->ar_description }}</p>
        </div>
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel" style="border: 0px;">
                <div class="x_title">
                    <button type="button" class="btn btn-round btn-success" data-toggle="modal"
                        data-target=".bs-example-modal-lg2">اختر الفرع</button>
                    <div class="modal fade bs-example-modal-lg2" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg" id="modal2">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel">اختر الفرع</h4>
                                    <button type="button" class="close" data-dismiss="modal"><span
                                            aria-hidden="true">×</span>
                                    </button>
                                </div>

                                <div class="modal-body">
                                    <form id="create-restaurant" data-parsley-validate
                                        class="form-horizontal form-label-left"
                                        action="{{ Route('branch.store_branch-ar',$rest_id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        {{csrf_field()  }}
                                        <input type="hidden" value="{{ $rest->id }}" name="rest_id" id="rest_id">
                                        <select class="form-control" id="branch_id" name="branch_id"
                                            required="required">
                                            @foreach (App\Http\Controllers\BranchController::getBranches($rest->id)
                                            as $branch)
                                            <option value="{{$branch->id}}">{{$branch->ar_branch_name}}</option>
                                            @endforeach
                                        </select>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">إلغاء</button>
                                            <button type="submit" class="btn btn-success">حفظ التغيرات</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                @if(Session::get('user_role')=='Administrator' || Session::get('user_role')=='Restaurant Admin')
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div class="item form-group">
                                <div class="col-md-12 col-sm-12 text-left">
                                    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                                        <div class="input-group">
                                            <button type="button" class="btn btn-round btn-success" data-toggle="modal"
                                                data-target=".bs-example-modal-lg1"> <i class="fa fa-plus-circle"></i>
                                                فرع جديد</button>
                                            <div class="modal fade bs-example-modal-lg1" tabindex="-1" role="dialog"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-lg" id="modal2">
                                                    <div class="modal-content">

                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="myModalLabel">فرع جديد </h4>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal"><span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        @if(App\Http\Controllers\BranchController::canAddBranch($rest->id))
                                                        <div class="modal-body">
                                                            <form id="create-restaurant" data-parsley-validate
                                                                class="form-horizontal form-label-left"
                                                                action="{{ Route('branch.store-ar') }}" method="POST"
                                                                enctype="multipart/form-data">
                                                                {{csrf_field()  }}
                                                                <input type="hidden" name="rest_id" id="rest_id"
                                                                    value="{{ $rest->id }}">


                                                                <div class="x_panel">
                                                                    <div class="x_title">
                                                                        <h2>مدير المطعم</h2>
                                                                        <div class="clearfix"></div>
                                                                    </div>
                                                                    <div class="x_content">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div class="item form-group">
                                                                                    <label
                                                                                        class="col-form-label col-md-3 col-sm-3 label-align"
                                                                                        for="branch_name">اسم الفرع<span
                                                                                            class="required">*</span>
                                                                                    </label>
                                                                                    <div class="col-md-6 col-sm-6 ">
                                                                                        <input type="text"
                                                                                            id="branch_name"
                                                                                            name="branch_name"
                                                                                            required="required"
                                                                                            class="form-control ">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="item form-group">
                                                                                    <label
                                                                                        class="col-form-label col-md-3 col-sm-3 label-align"
                                                                                        for="ar_branch_name">الاسم العربي<span
                                                                                            class="required">*</span>
                                                                                    </label>
                                                                                    <div class="col-md-6 col-sm-6 ">
                                                                                        <input type="text"
                                                                                            id="ar_branch_name"
                                                                                            name="ar_branch_name"
                                                                                            required="required"
                                                                                            class="form-control ">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="item form-group">
                                                                                    <label
                                                                                        class="col-form-label col-md-3 col-sm-3 label-align"
                                                                                        for="phone_number">رقم الهاتف<span
                                                                                            class="required">*</span>
                                                                                    </label>
                                                                                    <div class="col-md-6 col-sm-6 ">
                                                                                        <input type="text"
                                                                                            id="phone_number"
                                                                                            name="phone_number"
                                                                                            required="required"
                                                                                            class="form-control ">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="item form-group">
                                                                                    <label
                                                                                        class="col-form-label col-md-3 col-sm-3 label-align"
                                                                                        for="email">الايميل
                                                                                    </label>
                                                                                    <div class="col-md-6 col-sm-6 ">
                                                                                        <input type="text" id="email"
                                                                                            name="email"
                                                                                            class="form-control ">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="item form-group">
                                                                                    <label
                                                                                        class="col-form-label col-md-3 col-sm-3 label-align"
                                                                                        for="address">العنوان<span
                                                                                            class="required">*</span>
                                                                                    </label>
                                                                                    <div class="col-md-6 col-sm-6 ">
                                                                                        <input type="text" id="address"
                                                                                            name="address"
                                                                                            required="required"
                                                                                            class="form-control ">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="item form-group">
                                                                                    <label
                                                                                        class="col-form-label col-md-3 col-sm-3 label-align"
                                                                                        for="ar_address">العنوان بالعربي<span
                                                                                            class="required">*</span>
                                                                                    </label>
                                                                                    <div class="col-md-6 col-sm-6 ">
                                                                                        <input type="text"
                                                                                            id="ar_address"
                                                                                            name="ar_address"
                                                                                            required="required"
                                                                                            class="form-control ">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                <div class="x_panel">
                                                                    <div class="x_title">
                                                                        <h2>مدير الفرع</h2>
                                                                        <div class="clearfix"></div>
                                                                    </div>
                                                                    <div class="x_content">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div class="item form-group">
                                                                                    <label
                                                                                        class="col-form-label col-md-3 col-sm-3 label-align"
                                                                                        for="username">الاسم<span
                                                                                            class="required">*</span>
                                                                                    </label>
                                                                                    <div class="col-md-6 col-sm-6 ">
                                                                                        <input type="text" id="username"
                                                                                            name="username"
                                                                                            required="required"
                                                                                            class="form-control ">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="item form-group">
                                                                                    <label
                                                                                        class="col-form-label col-md-3 col-sm-3 label-align"
                                                                                        for="email">الاميل<span
                                                                                            class="required">*</span>
                                                                                    </label>
                                                                                    <div class="col-md-6 col-sm-6 ">
                                                                                        <input type="email" id="email"
                                                                                            name="email"
                                                                                            required="required"
                                                                                            class="form-control ">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="item form-group">
                                                                                    <label
                                                                                        class="col-form-label col-md-3 col-sm-3 label-align"
                                                                                        for="password">كلمة السر<span
                                                                                            class="required">*</span>
                                                                                    </label>
                                                                                    <div class="col-md-6 col-sm-6 ">
                                                                                        <input type="password"
                                                                                            id="password"
                                                                                            name="password"
                                                                                            required="required"
                                                                                            class="form-control ">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="item form-group">
                                                                                    <label
                                                                                        class="col-form-label col-md-3 col-sm-3 label-align"
                                                                                        for="c_password">تأكيد كلمة السر<span
                                                                                            class="required">*</span>
                                                                                    </label>
                                                                                    <div class="col-md-6 col-sm-6 ">
                                                                                        <input type="password"
                                                                                            id="c_password"
                                                                                            name="c_password"
                                                                                            required="required"
                                                                                            class="form-control ">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">إغلاق</button>
                                                                    <button class="btn btn-danger"
                                                                        type="reset">محي</button>
                                                                    <button type="submit" class="btn btn-success">حفظ التغيرات</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        @else
                                                        <div class="modal-body">
                                                            <div class="x_panel">
                                                                <div class="x_content">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <p>
                                                                            لقد قمت بإضافة العدد الأعظمي للفروع في خطتك الحالة</p>
                                                                            <p>إذا كنت تريد إضافة المزيد الرجاء <a
                                                                                    class="btn btn btn-round btn-success"
                                                                                    href="{{ Route('upgrade.plan-ar',['id'=>$rest_id]) }}">تحديث خطتك</a></p>
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
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                @endif
            </div>
            <div class="x_panel" style="border: 0px;">
                <div class="x_content">
                    @if(Session::get('ip_branch'))
                    <div class="row">
                        @foreach ($cats as $cat)
                        <div class="col-md-55">
                            <div class="well profile_view"
                                style="padding: 10px; border-radius: 15px; border-color: #093120; border-width: 2px;">
                                <a href="{{ Route('products.index-ar',$cat->id)}}">
                                    <div class="profile_img">

                                        <img class="img-responsive avatar-view"
                                            style="width: 100%; border-radius: 15px;"
                                            src="{{asset('images\product_categories\\').$cat->img_path}}" alt="image"
                                            title="{{ $cat->category_name }}" />
                                    </div>
                                    <div class="caption"
                                        style="height: 30px; border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;">
                                        <p><strong>{{ $cat->ar_category_name }}</strong></p>
                                    </div>
                                    @if(Session::get('user_role')=='Administrator'||Session::get('user_role')=='Restaurant Admin')
                                    <div>
                                        <p>
                                            <a data-toggle="tooltip" data-placement="bottom" title="تعديل"
                                                href="{{ Route('product-category.edi-ar',$cat->id) }}"><i
                                                    class="fa fa-edit fa-2x"></i></a>
                                            <a onclick="return confirm('هل أنت متأكد من حذف العنصر؟');"
                                                data-toggle="tooltip" data-placement="bottom" title="حذف"
                                                href="{{Route('product-category.delete-ar',$cat->id)}}"><i
                                                    class="fa fa-remove fa-2x"></i></a>
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
                                    <i class="fa fa-plus-circle"></i>
                                    إضافة نوع منتج</a>
                                <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
                                    aria-hidden="true" id="modal1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">إضافة نوع منتج</h4>
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
                                                    {{-- <div class="item form-group">
                                                                                <label
                                                                                    class="col-form-label col-md-3 col-sm-3 label-align"
                                                                                    for="img">Category
                                                                                    Image<span class="required">*</span>
                                                                                </label>
                                                                                <div class="col-md-6 col-sm-6 ">
                                                                                    <input type="file" id="img"
                                                                                        name="img" required="required"
                                                                                        class="form-control ">
                                                                                </div>
                                                                            </div> --}}
                                                    <div class="item form-group">


                                                    </div>
                                                    {{--  <div class="item form-group">

                                                                                <div class="col-md-6 col-sm-6 ">
                                                                                    <a class="btn btn-sucess" href="{{ Route('test') }}">Upload
                                                    Image</a>
                                            </div>
                                        </div> --}}

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
                @endif
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

<!-- /page content -->
@endsection
