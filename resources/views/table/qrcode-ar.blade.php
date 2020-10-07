@extends('layouts.master-ar')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>QR الطاولة</small></h3>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                {{!!$qr!!}}
                <img src="{{$image}}">
            </div>
        </div>

    </div>
    <a class="btn btn-success" href="/images/myw3schoolsimage.jpg" download="filename">تحميل</a>
</div>

<script>
    var canvas = document.getElementById("canvas");
    var ctx = canvas.getContext("2d");


    download_img = function(el) {
    var image = canvas.toDataURL("image/jpg");
    el.href = image;
    };
</script>
<!-- /page content -->
@endsection
