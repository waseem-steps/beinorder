@extends('layouts.master')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    <img src="{{ asset('images\covers\\').$rest->cover_photo }}">
    <div class="row">
        <div class="col-md-4">

            <img styple="width: 32px ;heigt:32px; display: block;" src="{{asset('images\restaurants\\').$rest->logo}}"
                alt="image" />

        </div>
        <div class="col-md-8">
            <strong>{{ $rest->rest_name }}</strong>
            <p>{{ $rest->description }}</p>

        </div>
    </div>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="x_panel">
        <div class="x_title">
            <button type="button" class="btn btn-round btn-success" data-toggle="modal" data-target=".bs-example-modal-lg2">Select Branch</button>
            <div class="modal fade bs-example-modal-lg2" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg" id="modal2">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Select Branch</h4>
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <form id="create-restaurant" data-parsley-validate class="form-horizontal form-label-left"
                                action="{{ Route('branch.store_branch',$rest_id) }}" method="POST" enctype="multipart/form-data">
                                {{csrf_field()  }}
                                <input type="hidden" value="{{ $rest->id }}" name="rest_id" id="rest_id">
<select class="form-control" id="branch_id" name="branch_id" required="required">
    @foreach (App\Http\Controllers\BranchController::getBranches($rest->id) as $branch)
    <option value="{{$branch->id}}">{{$branch->branch_name}}</option>
    @endforeach
</select>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success">Save
                                        changes</button>
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
                                        data-target=".bs-example-modal-lg1"> <i class="fa fa-plus-circle"></i> New
                                        Branch</button>
                                    <div class="modal fade bs-example-modal-lg1" tabindex="-1" role="dialog"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-lg" id="modal2">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="myModalLabel">New Branch</h4>
                                                    <button type="button" class="close" data-dismiss="modal"><span
                                                            aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                @if(App\Http\Controllers\BranchController::canAddBranch($rest->id))
                                                <div class="modal-body">
                                                    <form id="create-restaurant" data-parsley-validate
                                                        class="form-horizontal form-label-left"
                                                        action="{{ Route('branch.store') }}" method="POST"
                                                        enctype="multipart/form-data">
                                                        {{csrf_field()  }}
                                                        <input type="hidden" name="rest_id" id="rest_id"
                                                            value="{{ $rest->id }}">


                                                        <div class="x_panel">
                                                            <div class="x_title">
                                                                <h2>Restaurant Admin</h2>
                                                                <div class="clearfix"></div>
                                                            </div>
                                                            <div class="x_content">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="item form-group">
                                                                            <label
                                                                                class="col-form-label col-md-3 col-sm-3 label-align"
                                                                                for="branch_name">Branch
                                                                                Name<span class="required">*</span>
                                                                            </label>
                                                                            <div class="col-md-6 col-sm-6 ">
                                                                                <input type="text" id="branch_name"
                                                                                    name="branch_name"
                                                                                    required="required"
                                                                                    class="form-control ">
                                                                            </div>
                                                                        </div>
                                                                        <div class="item form-group">
                                                                            <label
                                                                                class="col-form-label col-md-3 col-sm-3 label-align"
                                                                                for="ar_branch_name">Arabic
                                                                                Branch
                                                                                Name<span class="required">*</span>
                                                                            </label>
                                                                            <div class="col-md-6 col-sm-6 ">
                                                                                <input type="text" id="ar_branch_name"
                                                                                    name="ar_branch_name"
                                                                                    required="required"
                                                                                    class="form-control ">
                                                                            </div>
                                                                        </div>
                                                                        <div class="item form-group">
                                                                            <label
                                                                                class="col-form-label col-md-3 col-sm-3 label-align"
                                                                                for="phone_number">Phone
                                                                                Number<span class="required">*</span>
                                                                            </label>
                                                                            <div class="col-md-6 col-sm-6 ">
                                                                                <input type="text" id="phone_number"
                                                                                    name="phone_number"
                                                                                    required="required"
                                                                                    class="form-control ">
                                                                            </div>
                                                                        </div>
                                                                        <div class="item form-group">
                                                                            <label
                                                                                class="col-form-label col-md-3 col-sm-3 label-align"
                                                                                for="email">Email
                                                                            </label>
                                                                            <div class="col-md-6 col-sm-6 ">
                                                                                <input type="text" id="email"
                                                                                    name="email" class="form-control ">
                                                                            </div>
                                                                        </div>
                                                                        <div class="item form-group">
                                                                            <label
                                                                                class="col-form-label col-md-3 col-sm-3 label-align"
                                                                                for="address">Address<span
                                                                                    class="required">*</span>
                                                                            </label>
                                                                            <div class="col-md-6 col-sm-6 ">
                                                                                <input type="text" id="address"
                                                                                    name="address" required="required"
                                                                                    class="form-control ">
                                                                            </div>
                                                                        </div>
                                                                        <div class="item form-group">
                                                                            <label
                                                                                class="col-form-label col-md-3 col-sm-3 label-align"
                                                                                for="ar_address">Arabic
                                                                                Address<span class="required">*</span>
                                                                            </label>
                                                                            <div class="col-md-6 col-sm-6 ">
                                                                                <input type="text" id="ar_address"
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
                                                                <h2>Branch Admin</h2>
                                                                <div class="clearfix"></div>
                                                            </div>
                                                            <div class="x_content">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="item form-group">
                                                                            <label
                                                                                class="col-form-label col-md-3 col-sm-3 label-align"
                                                                                for="username">Name<span
                                                                                    class="required">*</span>
                                                                            </label>
                                                                            <div class="col-md-6 col-sm-6 ">
                                                                                <input type="text" id="username"
                                                                                    name="username" required="required"
                                                                                    class="form-control ">
                                                                            </div>
                                                                        </div>
                                                                        <div class="item form-group">
                                                                            <label
                                                                                class="col-form-label col-md-3 col-sm-3 label-align"
                                                                                for="email">Email<span
                                                                                    class="required">*</span>
                                                                            </label>
                                                                            <div class="col-md-6 col-sm-6 ">
                                                                                <input type="email" id="email"
                                                                                    name="email" required="required"
                                                                                    class="form-control ">
                                                                            </div>
                                                                        </div>
                                                                        <div class="item form-group">
                                                                            <label
                                                                                class="col-form-label col-md-3 col-sm-3 label-align"
                                                                                for="password">Password<span
                                                                                    class="required">*</span>
                                                                            </label>
                                                                            <div class="col-md-6 col-sm-6 ">
                                                                                <input type="password" id="password"
                                                                                    name="password" required="required"
                                                                                    class="form-control ">
                                                                            </div>
                                                                        </div>
                                                                        <div class="item form-group">
                                                                            <label
                                                                                class="col-form-label col-md-3 col-sm-3 label-align"
                                                                                for="c_password">Confirm
                                                                                Password<span class="required">*</span>
                                                                            </label>
                                                                            <div class="col-md-6 col-sm-6 ">
                                                                                <input type="password" id="c_password"
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
                                                                data-dismiss="modal">Close</button>
                                                            <button class="btn btn-danger" type="reset">Reset</button>
                                                            <button type="submit" class="btn btn-success">Save
                                                                changes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                                @else
                                                <div class="modal-body">
                                                    <div class="x_panel">
                                                        <div class="x_content">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <p>You have already added the maximum branches of
                                                                        your active plan</p>
                                                                    <p>If you want to add more bracnhes please <a
                                                                            class="btn btn btn-round btn-success"
                                                                            href="{{ Route('upgrade.plan',['id'=>$rest_id]) }}">Upgrade
                                                                            your plan</a></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                @endif

                                            </div>
                                        </div>
                                    </div>

                                    {{--    <button type="button" class="btn btn-round btn-success" data-toggle="modal" data-target=".bs-example-modal-lg2"> <i
                                                    class="fa fa-plus-circle"></i> New Branch Admin
                                                </button>

                                        <div class="modal fade bs-example-modal-lg2" tabindex="-1" role="dialog"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-lg"  id="modal2">
                                                <div class="modal-content">

                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="myModalLabel">New Branch Admin</h4>
                                                        <button type="button" class="close" data-dismiss="modal"><span
                                                                aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="create-restaurant" data-parsley-validate
                                                            class="form-horizontal form-label-left"
                                                            action="#" method="POST"
                                                            enctype="multipart/form-data">
                                                            {{csrf_field()  }}
                                    <input type="hidden" name="rest_id" id="rest_id" value="{{ $rest->id }}">


                                    <div class="x_panel">
                                        <div class="x_title">
                                            <h2>Branch Name</h2>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="item form-group">
                                                        <label class="col-form-label col-md-3 col-sm-3 label-align"
                                                            for="branch_name">Branch
                                                            Name<span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 ">
                                                            <select class="form-control" id="branch" name="branch"
                                                                required="required">
                                                                @foreach
                                                                (App\Http\Controllers\BranchController::getBranches($rest->id)
                                                                as $branch)
                                                                <option value="{{$branch->id}}">{{$branch->branch_name}}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="x_panel">
                                        <div class="x_title">
                                            <h2>Branch Admin</h2>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="item form-group">
                                                        <label class="col-form-label col-md-3 col-sm-3 label-align"
                                                            for="username">Name<span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 ">
                                                            <input type="text" id="username" name="username"
                                                                required="required" class="form-control ">
                                                        </div>
                                                    </div>
                                                    <div class="item form-group">
                                                        <label class="col-form-label col-md-3 col-sm-3 label-align"
                                                            for="email">Email<span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 ">
                                                            <input type="email" id="email" name="email"
                                                                required="required" class="form-control ">
                                                        </div>
                                                    </div>
                                                    <div class="item form-group">
                                                        <label class="col-form-label col-md-3 col-sm-3 label-align"
                                                            for="password">Password<span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 ">
                                                            <input type="password" id="password" name="password"
                                                                required="required" class="form-control ">
                                                        </div>
                                                    </div>
                                                    <div class="item form-group">
                                                        <label class="col-form-label col-md-3 col-sm-3 label-align"
                                                            for="c_password">Confirm
                                                            Password<span class="required">*</span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 ">
                                                            <input type="password" id="c_password" name="c_password"
                                                                required="required" class="form-control ">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                        <button class="btn btn-danger" type="reset">Reset</button>
                                        <button type="submit" class="btn btn-success">Save
                                            changes</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>


</div>
</div>
</div>
@endif
</div>

<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                @if(Session::get('ip_branch'))
                <div class="row">
                    @foreach ($cats as $cat)
                    <div class="col-md-55">
                        <a href="{{ Route('products.index',$cat->id)}}">
                            <div class="">
                                <div class="image view view-first">
                                    <img style="width: 100%; display: block;"
                                        src="{{asset('images\product_categories\\').$cat->img_path}}" alt="image" />
                                </div>
                                <div class="caption">
                                    <p><strong>{{ $cat->category_name }}</strong></p>

                                    @if(Session::get('user_role')=='Administrator'||Session::get('user_role')=='Restaurant Admin')
                                    <p>
                                        <a data-toggle="tooltip" data-placement="bottom" title="Edit"
                                            href="{{ Route('product-category.edit',$cat->id) }}"><i
                                                class="fa fa-edit"></i></a>
                                        <a onclick="return confirm('Are you sure you want to delete this item?');" data-toggle="tooltip" data-placement="bottom" title="Delete"
                                            href="{{Route('product-category.delete',$cat->id)}}"><i
                                                class="fa fa-remove"></i></a></p>
                                    @endif

                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                    <div class="col-md-55">

                        <div class="">
                            <div class="image view view-first">
                                <div class="">
                                    <div class="page-title">
                                        @if(Session::get('user_role')=='Administrator'||Session::get('user_role')=='Restaurant Admin')
                                        <div class="title_left">
                                            <div class="input-group">
                                                <button type="button" class="btn btn-round btn-success"
                                                    data-toggle="modal" data-modal-id="modal1"
                                                    data-target=".bs-example-modal-lg"><i class="fa fa-plus-circle"></i>
                                                    New
                                                    Category</button>
                                                <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
                                                    aria-hidden="true" id="modal1">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">

                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="myModalLabel">New
                                                                    Category</h4>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal"><span
                                                                        aria-hidden="true">×</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form id="create-product-category" data-parsley-validate
                                                                    class="form-horizontal form-label-left"
                                                                    action="{{ Route('product-category.store',$rest_id) }}"
                                                                    method="POST" enctype="multipart/form-data">
                                                                    {{csrf_field()  }}
                                                                    <input type="hidden" name="rest_id" id="rest_id"
                                                                        value="{{ $rest_id }}" />
                                                                    <div class="item form-group">
                                                                        <label
                                                                            class="col-form-label col-md-3 col-sm-3 label-align"
                                                                            for="cat_name">Category
                                                                            Name<span class="required">*</span>
                                                                        </label>
                                                                        <div class="col-md-6 col-sm-6 ">
                                                                            <input type="text" id="cat_name"
                                                                                name="cat_name" required="required"
                                                                                class="form-control ">
                                                                        </div>
                                                                    </div>
                                                                    <div class="item form-group">
                                                                        <label
                                                                            class="col-form-label col-md-3 col-sm-3 label-align"
                                                                            for="ar_cat_name">Category Arabic
                                                                            Name<span class="required">*</span>
                                                                        </label>
                                                                        <div class="col-md-6 col-sm-6 ">
                                                                            <input type="text" id="ar_cat_name"
                                                                                name="ar_cat_name" required="required"
                                                                                class="form-control ">
                                                                        </div>
                                                                    </div>
                                                                    <div class="item form-group">
                                                                        <label
                                                                            class="col-form-label col-md-3 col-sm-3 label-align"
                                                                            for="img">Category
                                                                            Image<span class="required">*</span>
                                                                        </label>
                                                                        <div class="col-md-6 col-sm-6 ">
                                                                            <input type="file" id="img" name="img"
                                                                                required="required"
                                                                                class="form-control ">
                                                                        </div>
                                                                    </div>

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
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        </a>
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
                        <a class="btn btn-success form-control" href="{{ Route('cart.active-cart') }}">
                            {{ App\Http\Controllers\CartController::getTotalCarts(Session::get('ip_address')) }}&nbsp;<i
                                class="fa fa-shopping-cart"></i>&nbsp;|&nbsp;
                            Review Order&nbsp;|
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


@endsection
