@extends('layouts.master-ar')

@section('content')

<div class="right_col" role="main" style="background-color: #fff;">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>إعدادات مدير المطعم</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>الخيار المفضل</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br>
                        {{-- @if(Session::get('user_role')=='Restaurant Admin')
							@if($order->order_status_id==1)
								<a href="{{Route('order.checkout',$order->id)}}">
                        <i class="fa fa-plus fa-lg" aria-hidden="true"> >Done </i>
                        </a>
                        @endif

                        @if($order->order_status_id==2)
                        <a href="{{Route('order.checkout',$order->id)}}">
                            <i class="glyphicon glyphicon-ok" aria-hidden="true"></i>
                        </a>
                        @endif
                        @endif --}}
                        @if(Session::get('user_role')=='Restaurant Admin')
                        @if($settings->place_order_status == 0)
                        <a href="{{Route('restaurant.enable_place_order-ar',$settings->id)}}">
                            <i class="fa fa-plus-circle fa-lg" aria-hidden="true"> تفعيل إمكانية الطلب</i>
                        </a>
                        @endif
                        @if($settings->place_order_status == 1)
                        <a href="{{Route('restaurant.disable_place_order-ar',$settings->id)}}">
                            <i class="fa fa-minus-circle fa-lg" aria-hidden="true"> إلغاء إمكانية الطلب</i>
                        </a>
                        @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
