@extends('layouts.master')

@section('content')
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Product Categories Management</small></h3>
            </div>
            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                    <div class="input-group">
                        <button type="button" class="btn btn-round btn-success" data-toggle="modal"
                            data-target=".bs-example-modal-lg"><i class="fa fa-plus-circle"></i> New
                            Product Category</button>

                        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">New Product Category</h4>
                                        <button type="button" class="close" data-dismiss="modal"><span
                                                aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="create-product-category" data-parsley-validate
                                            class="form-horizontal form-label-left"
                                            action="{{ Route('product-category.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            {{csrf_field()  }}
                                            <div class="item form-group">
                                                <label class="col-form-label col-md-3 col-sm-3 label-align"
                                                    for="cat_name">Category Name<span class="required">*</span>
                                                </label>
                                                <div class="col-md-6 col-sm-6 ">
                                                    <input type="text" id="cat_name" name="cat_name"
                                                        required="required" class="form-control ">
                                                </div>
                                            </div>
                                            <div class="item form-group">
                                                <label class="col-form-label col-md-3 col-sm-3 label-align"
                                                    for="img">Image<span class="required">*</span>
                                                </label>
                                                <div class="col-md-6 col-sm-6 ">
                                                    <input type="file" id="img" name="img" required="required"
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
                        <h2>Available Product Categories </h2>
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
                                                <th>Product Category N9ame</th>
                                                <th>Image</th>
                                                <th>Creation Date</th>
                                                <th>Last Update Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($cats as $cat)
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td>{{$cat->cat_name}}</td>
                                                <td><img style="width: 25%; height:25% display: block;"
                                                        src="{{ asset('images\product_categories\\').$cat->img_path }}" />
                                                </td>
                                                <td>{{$cat->created_at}}</td>
                                                <td>{{$cat->updated_at}}</td>
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
<!-- /page content -->
@endsection
