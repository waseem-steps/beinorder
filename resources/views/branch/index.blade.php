@extends('layouts.master')

@section('content')
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Branches Management</small></h3>
            </div>
            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                    <div class="input-group">
                      {{--   <button type="button" class="btn btn-round btn-success" data-toggle="modal"
                            data-target=".bs-example-modal-lg"><i class="fa fa-plus-circle"></i> New
                            Branch</button> --}}

                        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">New Branch</h4>
                                        <button type="button" class="close" data-dismiss="modal"><span
                                                aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="create-restaurant" data-parsley-validate
                                            class="form-horizontal form-label-left" action="{{ Route('branch.store') }}"
                                            method="POST" enctype="multipart/form-data">
                                            {{csrf_field()  }}
                                            <input type="hidden" name="rest_id" id="rest_id" value="{{ $rest->id }}">
                                            <div class="item form-group">
                                                <label class="col-form-label col-md-3 col-sm-3 label-align"
                                                    for="branch_name">Branch Name<span class="required">*</span>
                                                </label>
                                                <div class="col-md-6 col-sm-6 ">
                                                    <input type="text" id="branch_name" name="branch_name"
                                                        required="required" class="form-control ">
                                                </div>
                                            </div>
                                            <div class="item form-group">
                                                <label class="col-form-label col-md-3 col-sm-3 label-align"
                                                    for="phone_number">Phone
                                                    Number<span class="required">*</span>
                                                </label>
                                                <div class="col-md-6 col-sm-6 ">
                                                    <input type="text" id="phone_number" name="phone_number"
                                                        required="required" class="form-control ">
                                                </div>
                                            </div>
                                            <div class="item form-group">
                                                <label class="col-form-label col-md-3 col-sm-3 label-align"
                                                    for="email">Email
                                                </label>
                                                <div class="col-md-6 col-sm-6 ">
                                                    <input type="text" id="email" name="email" class="form-control ">
                                                </div>
                                            </div>
                                            <div class="item form-group">
                                                <label class="col-form-label col-md-3 col-sm-3 label-align"
                                                    for="address">Address<span class="required">*</span>
                                                </label>
                                                <div class="col-md-6 col-sm-6 ">
                                                    <input type="text" id="address" name="address" required="required"
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
                        <h2>{{ $rest->rest_name }} Branches </h2>
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
                                                <th>Branch Name</th>
                                                <th>Email</th>
                                                <th>Phone Number</th>
                                                <td>Address</td>
                                                <th>Restaurant</th>
                                                <th>Status</th>
                                                <th>Created at</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($branches as $branch)
                                            <tr>
                                                <td></td>
                                                <td>@if($branch->status >0)
                                                <a data-toggle="tooltip" data-placement="bottom" title="Lock" href="{{ Route('branch.lock',$branch->id) }}"><i
                                                        class="fa fa-lock"></i></a>
                                                @else
                                                <a data-toggle="tooltip" data-placement="bottom" title="Unlock" href="{{ Route('branch.unlock',$branch->id) }}"><i
                                                        class="fa fa-unlock"></i></a>
                                                @endif
                                                <a data-toggle="tooltip" data-placement="bottom" title="View QrCode"
                                                    href="{{ Route('branch.qrcode',$branch->id) }}"><i class="fa fa-qrcode"></i></a>
                                                <a data-toggle="tooltip" data-placement="bottom" title="Edit" href="{{ Route('branch.edit',$branch->id) }}"><i
                                                        class="fa fa-edit"></i></a>
                                                        <a data-toggle="tooltip" data-placement="bottom" title="Users Management"
                                                            href="{{ Route('branch.admins',$branch->id) }}"><i class="fa fa-user"></i></a>
                                                <a onclick="return confirm('Are you sure you want to delete this item?');" data-toggle="tooltip" data-placement="bottom" title="Delete" href="{{Route('branch.delete',$branch->id)}}"><i
                                                        class="fa fa-remove"></i></a></td>
                                                <td>{{ $branch->branch_name }}</td>
                                                <td>{{ $branch->email }}</td>
                                                <td>{{ $branch->phone_number }}</td>
                                                <td>{{ $branch->address }}</td>
                                                <td>{{ $rest->rest_name }}</td>
                                                <td>@if($branch->status>0)
                                                    Active
                                                    @else
                                                    Closed
                                                    @endif</td>
                                                <td>{{ !empty($order->created_at) ? $order->created_at:'' }}</td>
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
