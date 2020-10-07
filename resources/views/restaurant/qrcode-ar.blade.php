@extends('layouts.master-ar')

@section('content')
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>QR المطعم</small></h3>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 ">


                <form id="qr-restaurant" data-parsley-validate class="form-horizontal form-label-left" action="#"
                    method="POST">
                    {{csrf_field()  }}
                    <div class="item form-group">
                     <a download="1">{!! $qr !!}</a>
                    </div>
                    <div class="modal-footer">
                    <button type="submit" class="btn btn-success">حفظ الكود</button></div>
                </form>

            </div>

        </div>
    </div>
</div>
<!-- /page content -->
@endsection
