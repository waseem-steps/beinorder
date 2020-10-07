@extends('layouts.master')

@section('content')
<!-- page content -->
<div class="right_col" role="main">
    <div class="">


        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_content">
                        <div class="row">
                            @foreach ($rests as $rest)
                            <div class="col-md-55">
                                <a href="{{ Route('product-categories.rest-cat',$rest->id)}}">
                                    <div class="thumbnail">
                                        <div class="image view view-first">
                                            <img style="width: 100%; display: block;"
                                                src="{{asset('images\restaurants\\').$rest->logo}}" alt="image" />
                                        </div>
                                        <div class="caption">
                                            <p><strong>{{ $rest->rest_name }}</strong>
                                            </p>
                                            <p>{{ $rest->description }}</p>
                                            <p>

                                                @if(Session::get('user_role')=='Administrator'||Session::get('user_role')=='Restaurant Admin')
                                                @if($rest->status ==1)
                                                <a data-toggle="tooltip" data-placement="bottom" title="Lock"
                                                    href="{{ Route('restaurant.lock',$rest->id) }}"><i
                                                        class="fa fa-lock"></i></a>
                                                @else
                                                <a data-toggle="tooltip" data-placement="bottom" title="Unlock"
                                                    href="{{ Route('restaurant.unlock',$rest->id) }}"><i
                                                        class="fa fa-unlock"></i></a>
                                                @endif

                                                <a data-toggle="tooltip" data-placement="bottom"
                                                    title="Branch Management"
                                                    href="{{ Route('branches.index',$rest->id) }}"><i
                                                        class="fa fa-sitemap"></i></a>
                                                <a data-toggle="tooltip" data-placement="bottom" title="Edit"
                                                    href="{{ Route('restaurant.edit',$rest->id) }}"><i
                                                        class="fa fa-edit"></i></a>
                                                @endif
                                                @if(Session::get('user_role')=='Administrator')
                                               {{--  <a data-toggle="tooltip" data-placement="bottom" title="Delete"
                                                    href="{{Route('restaurant.delete',$rest->id)}}"><i
                                                        class="fa fa-remove"></i></a> --}}
                                                @endif</p>
                                        </div>

                                    </div>
                                </a>
                            </div>
                            @endforeach
                            <div class="col-md-55">
                                <div class="">
                                    <div class="image view view-first">
                                        <div class="page-title">
                                            @if(Session::get('user_role')=='Administrator')
                                            <div class="title_left">
                                                <div class="input-group">
                                                    <button type="button" class="btn btn-round btn-success"
                                                        data-toggle="modal" data-target=".bs-example-modal-lg"><i
                                                            class="fa fa-plus-circle"></i> New
                                                        Restaurant</button>

                                                    <div class="modal fade bs-example-modal-lg" tabindex="-1"
                                                        role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">

                                                                <div class="modal-header">
                                                                    <h4 class="modal-title" id="myModalLabel">New
                                                                        Restaurant</h4>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal"><span
                                                                            aria-hidden="true">×</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form id="create-restaurant" data-parsley-validate
                                                                        class="form-horizontal form-label-left"
                                                                        action="{{ Route('restaurant.store') }}"
                                                                        method="POST" enctype="multipart/form-data">
                                                                        {{csrf_field()  }}
                                                                        <div class="item form-group">
                                                                            <label
                                                                                class="col-form-label col-md-3 col-sm-3 label-align"
                                                                                for="rest_name">Restaurant
                                                                                Name<span class="required">*</span>
                                                                            </label>
                                                                            <div class="col-md-6 col-sm-6 ">
                                                                                <input type="text" id="rest_name"
                                                                                    name="rest_name" required="required"
                                                                                    class="form-control ">
                                                                            </div>
                                                                        </div>
                                                                        <div class="item form-group">
                                                                            <label
                                                                                class="col-form-label col-md-3 col-sm-3 label-align"
                                                                                for="ar_rest_name">Restaurant
                                                                                Arabic Name<span
                                                                                    class="required">*</span>
                                                                            </label>
                                                                            <div class="col-md-6 col-sm-6 ">
                                                                                <input type="text" id="ar_rest_name"
                                                                                    name="ar_rest_name"
                                                                                    required="required"
                                                                                    class="form-control ">
                                                                            </div>
                                                                        </div>
                                                                        <div class="item form-group">
                                                                            <label
                                                                                class="col-form-label col-md-3 col-sm-3 label-align"
                                                                                for="description">Description<span
                                                                                    class="required">*</span>
                                                                            </label>
                                                                            <div class="col-md-6 col-sm-6 ">
                                                                                <textarea id="description"
                                                                                    name="description"
                                                                                    required="required"
                                                                                    class="form-control "></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="item form-group">
                                                                            <label
                                                                                class="col-form-label col-md-3 col-sm-3 label-align"
                                                                                for="ar_description">Arabic
                                                                                Description<span
                                                                                    class="required">*</span>
                                                                            </label>
                                                                            <div class="col-md-6 col-sm-6 ">
                                                                                <textarea id="ar_description"
                                                                                    name="ar_description"
                                                                                    required="required"
                                                                                    class="form-control "></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="item form-group">
                                                                            <label
                                                                                class="col-form-label col-md-3 col-sm-3 label-align"
                                                                                for="country">Country<span
                                                                                    class="required">*</span>
                                                                            </label>
                                                                            <div class="col-md-6 col-sm-6 ">
                                                                                <select class="form-control"
                                                                                    id="country" name="country"
                                                                                    required="required">
                                                                                    @foreach($countries as $country)
                                                                                    <option value="{{ $country->id }}">
                                                                                        {{  $country->country_name }}
                                                                                    </option>
                                                                                    @endforeach

                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="item form-group">
                                                                            <label
                                                                                class="col-form-label col-md-3 col-sm-3 label-align"
                                                                                for="logo">Logo<span
                                                                                    class="required">*</span>
                                                                            </label>
                                                                            <div class="col-md-6 col-sm-6 ">
                                                                                <input type="file" id="logo" name="logo"
                                                                                    required="required"
                                                                                    class="form-control ">
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
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
