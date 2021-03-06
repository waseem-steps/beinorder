@extends('layouts.master')

@section('content')
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Update Branch Admin</small></h3>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <form id="update-branch" data-parsley-validate class="form-horizontal form-label-left"
                    action="{{ Route('branch-admin.update',$admin->id) }}" method="POST">
                    {{csrf_field()  }}
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="username">User Name<span
                                class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                            <input type="text" value="{{ $admin->name }}" id="username" name="username"
                                required="required" class="form-control ">
                        </div>
                    </div>

                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="email">User Email<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                            <input type="email" value="{{ $admin->email }}" id="email" name="email" required="required"
                                class="form-control ">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="password">Password<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 ">
                            <input type="password" value="{{ $admin->password }}" id="password" name="password" required="required"
                                class="form-control ">
                        </div>
                    </div>
                    <div class="modal-footer">
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
