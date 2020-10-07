@extends('layouts.master-ar')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>
        <div class="row">

                @foreach($orders as $order)
				<div class="col-md-12 col-sm-12">
                <div class="x_panel" style="height: auto;" id='dt_name{{ $order->id }}'>
                    <div class="x_title">
                        <h2>الطاولة {{ $order->table_no }}
                            @if($order->order_status_id==1)
                            <strong class="badge badge-danger">
                                تم الإرسال
                            </strong>
                            @endif
                            @if($order->order_status_id==2)
                            <strong class="badge badge-warning">
                                قيد التحضير
                            </strong>
                            @endif
                            @if($order->order_status_id==3)
                            <strong class="badge badge-success">
                                انتهى
                            </strong>
                            @endif
                        </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content" style="display: none;">
                        <section class="content invoice">
                            <div class="row">
                                <div class="col-xs-12 invoice-header">
                                    <h1><i class="fa fa-globe"></i> الفاتورة</h1>
                                </div>
                            </div>
                            <div class="row invoice-info">
                                <div class="col-sm-12 invoice-col">
                                    معلومات المطعم
                                    <address>
                                        <strong>{{ $order->ar_rest_name }}</strong>
                                        <br>الطاولة: {{ $order->table_no }}
                                        <br><strong>@if($order->order_type==1)
                                            داخلي
                                            @else
                                            خارجي
                                            @endif</strong>
                                        <br>
                                    </address>
                                </div>
                            </div>
                            <div class="row">
							{{-- <div class="col-xs-12 table"> --}}
								<div class="col-sm-12">
								<div class="card-box table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th style="width: 49%">الوصف</th>
                                                <th>الحالة</th>
                                                <th>الملاحظات</th>
                                                <th>الكمية</th>
                                                <th>السعر</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach(App\Http\Controllers\OrderController::getTableOrders($order->table_id,$order->rest_id,Session::get('client_ip'),$order->order_code) as $key =>$order1)
                                                @foreach(App\Http\Controllers\OrderDetailController::getDetails($order1->id)
                                                as  $detail)

                                                <tr>

                                                    <td>{{ $key+1 }}</td>
                                                    <td>{{ $detail->ar_description }}</td>
                                                    <td>
                                                        @if($order1->order_status_id==1)
                                                        <strong class="badge badge-danger">
                                                            تم الإرسال
                                                        </strong>
                                                        @endif
                                                        @if($order1->order_status_id==2)
                                                        <strong class="badge badge-warning">
                                                            قيد التحضير
                                                        </strong>
                                                        @endif
                                                        @if($order1->order_status_id==3)
                                                        <strong class="badge badge-success">
                                                            انتهى
                                                        </strong>
                                                        @endif
                                                    </td>
                                                    <td>{{ $detail->notes }}</td>
                                                    <td>{{ $detail->quantity }}</td>
                                                    <td>{{ $detail->price }}
                                                        &nbsp;{{ App\Http\Controllers\CountryController::getCurrency($order->rest_id) }}
                                                    </td>
                                                </tr>
                                                @endforeach
                                            @endforeach
                                            <tr>
                                                <td colspan="5"></td>
                                                <td>
													<strong>
														@if(Session::get('user_role')=='Anonymous')
															{{ App\Http\Controllers\OrderController::getTableTotalOrder($order->table_id,$order->rest_id,Session::get('client_ip'),$order->order_code) }}&nbsp;{{ App\Http\Controllers\CountryController::getCurrency($order->rest_id) }}
														@endif
														@if(Session::get('user_role')=='Restaurant Admin')
															{{ App\Http\Controllers\OrderController::getTableTotalOrderRestAdmin($order->table_id,$order->rest_id,Session::get('client_ip'),$order->order_code) }}&nbsp;{{ App\Http\Controllers\CountryController::getCurrency($order->rest_id) }}
														@endif
													</strong>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
								</div>
                                </div>
                            </div>
                            @if(Session::get('user_role')=='Restaurant Admin')
                                <div class="row no-print">
                                    <div class="col-xs-12">
                                        <a target="_blank" class="btn btn-success" href="{{Route('order.printInternalTable-ar',['id'=>$order->table_id])}}">
                                            <i class="fa fa-print fa-lg"></i> <strong>طباعة</strong>
                                        </a>

                                        <a class="btn btn-success" href="{{Route('table.close-ar',$order->table_id)}}">
                                            <i class="fa fa-sign-out fa-lg"></i> <strong>إغلاق</strong>
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </section>
                    </div>
                </div>
				</div>
                @endforeach

        </div>
    </div>
</div>
@endsection
