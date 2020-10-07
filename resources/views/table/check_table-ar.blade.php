@extends('layouts.master-ar')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>الرجاء إدخال كود الطاولة...</small></h3>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 text-center">
                <div class="col-md-12">
                    <div class="well profile_view"
                        style="padding: 10px; border-radius: 15px; border-color: #093120; border-width: 2px;">
                        @if (session('status'))
                        <div class="alert alert-danger mt-5">
                            {{ session('status') }}
                        </div>
                        @endif
                        <form id="create-restaurant" data-parsley-validate class="form-horizontal form-label-left"
                            action="{{ Route('table.product-categories-ar') }}" method="GET" enctype="multipart/form-data">
                            {{csrf_field()  }}
                            <input type="hidden" name="rest_id" id="rest_id" value="{{ $rest_id }}">
                            <input type="hidden" name="table_id" id="table_id" value="{{ $table_id }}">
                            <div class="item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="table_code">كود الطاولة<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 ">
                                    <input type="text" id="table_code" name="table_code" required="required"
                                        class="form-control ">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-round btn-success">
                                <i class="fa fa-search"></i> عرض المينيو
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
