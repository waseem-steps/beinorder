@extends('layouts.master')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12">
                @foreach($orders as $order)
                <div class="x_panel" style="height: auto;" id='dt_name{{ $order->id }}'>
                    <div class="x_title">
                        <h2>Table {{ $order->table_no }} - {{ $order->order_code }} - {{ $order->created_at }}</h2>
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
                                    <h1>
                                        <i class="fa fa-globe"></i> Invoice
                                    </h1>
                                </div>

                            </div>

                            <div class="row invoice-info">
                                <div class="col-sm-3 invoice-col">
                                    Restaurant Information
                                    <address>
                                        <strong>{{ $order->rest_name }}</strong>
                                        <br>Table: {{ $order->table_no }}
                                        <br><strong>@if($order->order_type==1)
                                            Internal
                                            @else
                                            External
                                            @endif</strong>
                                        <br>
                                    </address>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-3 invoice-col"></div>
                                <!-- /.col -->
                                <div class="col-sm-3 invoice-col"></div>
                                <!-- /.col -->
                                <div class="col-sm-3 invoice-col">
                                    <b>Invoice Information</b>
                                    <br>
                                    <b>Order ID:</b> {{ $order->order_code }}
                                    <br>
                                    <b>Payment Method:</b> {{ $order->payment_method }}
                                    <br>
                                    <b>Order Time:</b> {{ $order->created_at }}
                                    <br>
                                    <b>Last Update:</b> {{ $order->updated_at }}
                                    <br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 table">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th style="width: 49%">Description</th>
                                                <th>Status</th>
                                                <th>Notes</th>
                                                <th>Qty</th>
                                                <th>Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach(App\Http\Controllers\OrderHistoryController::getTableOrders($order->table_id,$order->rest_id,Session::get('client_ip'),$order->order_code) as $key =>$order1)
                                                @foreach(App\Http\Controllers\OrderDetailController::getDetails($order1->order_id) as  $detail)
                                                <tr>

                                                    <td>{{ $key+1 }}</td>
                                                    <td>{{ $detail->description }}</td>
                                                    <td>
                                                        @if($order1->order_status_id==1)
                                                        <strong class="badge badge-danger">
                                                            Submitted
                                                        </strong>
                                                        @endif
                                                        @if($order1->order_status_id==2)
                                                        <strong class="badge badge-warning">
                                                            Preparing
                                                        </strong>
                                                        @endif
                                                        @if($order1->order_status_id==3)
                                                        <strong class="badge badge-success">
                                                            Done
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
															{{ App\Http\Controllers\OrderHistoryController::getTableTotalOrderRestAdmin($order->table_id,$order->rest_id,Session::get('client_ip'),$order->order_code) }}&nbsp;{{ App\Http\Controllers\CountryController::getCurrency($order->rest_id) }}
														@endif
													</strong>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                            
                            @if(Session::get('user_role')=='Restaurant Admin')
                                <div class="row no-print">
                                    <div class="col-xs-12">
                                        <a target="_blank" class="btn btn-success" href="{{Route('orderHistory.printInternalTable',['id'=>$order->order_code])}}">
                                            <i class="fa fa-print fa-lg"></i> <strong>Print</strong>
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </section>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>

</div>



@endsection
