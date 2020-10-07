@extends('layouts.master')

@section('content')

<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Restaurants Management</small></h3>
            </div>
            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                    <div class="input-group">
                        <button type="button" class="btn btn-round btn-success" data-toggle="modal"
                            data-target=".bs-example-modal-lg"><i class="fa fa-plus-circle"></i> New
                            Restaurant</button>

                        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">New Restaurant</h4>
                                        <button type="button" class="close" data-dismiss="modal"><span
                                                aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="create-restaurant" data-parsley-validate
                                            class="form-horizontal form-label-left"
                                            action="{{ Route('restaurant.store') }}" method="POST" enctype="multipart/form-data">
                                            {{csrf_field()  }}
                                            <div class="item form-group">
                                                <label class="col-form-label col-md-3 col-sm-3 label-align"
                                                    for="rest_name">Restaurant Name<span class="required">*</span>
                                                </label>
                                                <div class="col-md-6 col-sm-6 ">
                                                    <input type="text" id="rest_name" name="rest_name"
                                                        required="required" class="form-control ">
                                                </div>
                                            </div>
                                            <div class="item form-group">
                                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="ar_rest_name">Restaurant Arabic Name<span
                                                        class="required">*</span>
                                                </label>
                                                <div class="col-md-6 col-sm-6 ">
                                                    <input type="text" id="ar_rest_name" name="ar_rest_name" required="required" class="form-control ">
                                                </div>
                                            </div>
                                            <div class="item form-group">
                                                <label class="col-form-label col-md-3 col-sm-3 label-align"
                                                    for="description">Description<span class="required">*</span>
                                                </label>
                                                <div class="col-md-6 col-sm-6 ">
                                                    <textarea id="description" name="description"
                                                        required="required" class="form-control "></textarea>
                                                </div>
                                            </div>
                                            <div class="item form-group">
                                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="ar_description">Arabic Description<span
                                                        class="required">*</span>
                                                </label>
                                                <div class="col-md-6 col-sm-6 ">
                                                    <textarea id="ar_description" name="ar_description" required="required" class="form-control "></textarea>
                                                </div>
                                            </div>
                                            <div class="item form-group">
                                                <label class="col-form-label col-md-3 col-sm-3 label-align"
                                                    for="country">Country<span class="required">*</span>
                                                </label>
                                                <div class="col-md-6 col-sm-6 ">
                                                    <select class="form-control" id="country" name="country"
                                                        required="required">
                                                        @foreach($countries as $country)
                                                        <option value="{{ $country->id }}">
                                                            {{  $country->country_name }}</option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="item form-group">
                                                <label class="col-form-label col-md-3 col-sm-3 label-align"
                                                    for="logo">Logo<span class="required">*</span>
                                                </label>
                                                <div class="col-md-6 col-sm-6 ">
                                                    <input type="file" id="logo" name="logo" required="required"
                                                        class="form-control ">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Available Restaurants </h2>
                        <h2>
                        <a data-toggle="tooltip" data-placement="bottom" title="All Restaurants" href="{{ Route('restaurants.active') }}"><i
                                class="fa fa-eye"></i></a></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box table-responsive">
                                    <table id="datatable-responsive"
                                        class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                                        width="100%">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <td></td>
                                                <th>Restaurant name</th>
                                                <th>Description</th>
                                                <th>Phone Number</th>
                                                <th>Address</th>
                                                <th>Email</th>
                                                <th>Country</th>
                                                <th>Status</th>
                                                <th>Creation Date</th>
                                                <th>Last Update Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($rests as $rest)
                                            <tr>
                                                <td></td>
                                                <td>
                                                    @if($rest->status ==1)
                                                    <a data-toggle="tooltip" data-placement="bottom" title="Lock" href="{{ Route('restaurant.lock',$rest->id) }}"><i
                                                            class="fa fa-lock"></i></a>
                                                    @else
                                                    <a data-toggle="tooltip" data-placement="bottom" title="Unlock" href="{{ Route('restaurant.unlock',$rest->id) }}"><i
                                                            class="fa fa-unlock"></i></a>
                                                    @endif
                                                    <a data-toggle="tooltip" data-placement="bottom" title="Branch Management"
                                                        href="{{ Route('branches.index',$rest->id) }}"><i class="fa fa-sitemap"></i></a>
                                                        <a data-toggle="tooltip" data-placement="bottom" title="Products"
                                                            href="{{ Route('products.index',$rest->id) }}"><i class="fa fa-plus-circle"></i></a>
                                                    <a data-toggle="tooltip" data-placement="bottom" title="View QrCode" href="{{ Route('restaurant.qrcode',$rest->id) }}"><i
                                                            class="fa fa-qrcode"></i></a>
                                                    <a data-toggle="tooltip" data-placement="bottom" title="Edit" href="{{ Route('restaurant.edit',$rest->id) }}"><i
                                                            class="fa fa-edit"></i></a>
                                                    <a onclick="return confirm('Are you sure you want to delete this item?');" data-toggle="tooltip" data-placement="bottom" title="Delete" href="{{Route('restaurant.delete',$rest->id)}}"><i
                                                            class="fa fa-remove"></i></a></td>
                                                <td><img style="width: 100%; display: block;" src="{{asset('images\restaurants\\').$rest->logo}}" alt="image" /></td>
                                                <td>{{$rest->rest_name}}</td>
                                                <td>{{$rest->description}}</td>
                                                <td>{{$rest->phone_number}}</td>
                                                <td>{{$rest->address}}</td>
                                                <td>{{$rest->email}}</td>
                                                <td>{{$rest->country->country_name }}</td>
                                                @if($rest->status ==1)
                                                <td>Active</td>
                                                @else
                                                <td>Locked</td>
                                                @endif
                                                <td>{{$rest->created_at}}</td>
                                                <td>{{$rest->updated_at}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
