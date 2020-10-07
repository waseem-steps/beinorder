@extends('layouts.master')

@section('content')
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Update Branch</small></h3>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <form id="update-branch" data-parsley-validate class="form-horizontal form-label-left"
                    action="{{ Route('branch.update',$branch->id) }}" method="POST">
                    {{csrf_field()  }}
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="branch_name">Banch Name<span
                                class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                            <input type="text" value="{{ $branch->branch_name }}" id="branch_name" name="branch_name"
                                required="required" class="form-control ">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="ar_branch_name">Arabic Banch Name<span
                                class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                            <input type="text" value="{{ $branch->ar_branch_name }}" id="ar_branch_name" name="ar_branch_name" required="required"
                                class="form-control ">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="phone_number">Phone Number<span
                                class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                            <input type="text" id="phone_number" value="{{ $branch->phone_number }}" name="phone_number"
                                required="required" class="form-control ">
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="email">Email
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                            <input type="text" id="email" name="email" value="{{ $branch->email }}" class="form-control ">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="address">Address<span
                                class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                            <input type="text" id="address" value="{{ $branch->address }}" name="address"
                                required="required" class="form-control ">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="ar_address">Arabic Address<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                            <input type="text" id="ar_address" value="{{ $branch->ar_address }}" name="ar_address" required="required"
                                class="form-control ">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" type="reset">Reset</button>
                        <button type="submit" class="btn btn-success">Save
                            Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->
@endsection
