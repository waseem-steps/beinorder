@extends('layouts.master')

@section('content')

{{-- <script type="text/javascript">
    function autoRefreshPage()
    {
        window.location = window.location.href;
    }
    setInterval('autoRefreshPage()', 30000);
</script> --}}
<!-- page content -->

<div class="right_col" role="main">
    @if(Session::get('user_role')=='Branch Admin')
    <audio id="xyz" src="{{ asset('sounds\bell_ring.mp3') }}" preload="auto"></audio>
    <script src="https://js.pusher.com/4.1/pusher.min.js"></script>

    <script>
        var pusher = new Pusher('{{env("MIX_PUSHER_APP_KEY")}}', {
                  cluster: '{{env("PUSHER_APP_CLUSTER")}}',
                  encrypted: true
                });

                 var c='notify-channel'+'{{Auth::id()}}';
                var channel = pusher.subscribe(c);


                channel.bind('App\\Events\\Notify', function(data) {
                    location.reload();

                });
    </script>
    @endif
    <div class="">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12">
                @foreach($orders as $order)
                    <div class="x_panel" style="height: auto;" id='dt_name{{ $order->id }}'>
                        <div class="x_title">
                            <h2>{{ $order->order_code }}
								@if($order->order_status_id==1)
									<strong class="badge badge-danger">
										Submitted
									</strong>
								@endif
								@if($order->order_status_id==2)
									<strong class="badge badge-warning">
										Preparing
									</strong>
								@endif
								@if($order->order_status_id==3)
									<strong class="badge badge-success">
										Done
									</strong>
								@endif
                                @if(Session::get('user_role')=='Branch Admin')
								@if($order->order_status_id==1)
									<a href="{{Route('order.confirm',$order->id)}}">
										<i class="glyphicon glyphicon-plus" aria-hidden="true"></i>
									</a>
                                @endif

								@if($order->order_status_id==2)
									<a href="{{Route('order.checkout',$order->id)}}">
										<i class="glyphicon glyphicon-ok" aria-hidden="true"></i>
									</a>
                                @endif
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
                                        <h1>
                                            <i class="fa fa-globe"></i> Invoice.
                                            <small class="pull-right">Time: {{ $order->created_at }}</small>
                                        </h1>
                                    </div>

                                </div>

                                <div class="row invoice-info">
                                    <div class="col-sm-3 invoice-col">
                                        Restaurant Information
                                        <address>
                                            <strong>{{ $order->rest_name }}</strong>
                                            <br>{{ $order->branch_name }}
                                            <br><strong>@if($order->order_type==1)
                                            Internal
                                            @else
                                            External
                                            @endif</strong>
                                            <br>
                                        </address>
                                    </div>

                                    <div class="col-sm-3 invoice-col">
                                        Customer Information
                                        <address>
                                            <strong>{{ $order->customer_name }}</strong>
                                            <br>{{ $order->phone_number }}
                                            <br>{{ $order->customer_email }}
                                        </address>
                                    </div>

                                    <div class="col-sm-3 invoice-col">
                                        Car Information
                                        <address>
                                            <strong>{{ $order->car_type }}</strong>
                                            <br>{{ $order->car_color }}
                                            <br>{{ $order->li_number }}
                                        </address>
                                    </div>

                                    <div class="col-sm-3 invoice-col">
                                        <b>Invoice Information</b>
                                        <br>
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
                                                    <th>Notes</th>
                                                    <th>Qty</th>
                                                    <th>Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach(App\Http\Controllers\OrderDetailController::getDetails($order->id)
                                                as $key => $detail)

                                                    <tr>

                                                        <td>{{ $key+1 }}</td>
                                                        <td>{{ $detail->description }}</td>
                                                        <td>{{ $detail->notes }}</td>
                                                        <td>{{ $detail->quantity }}</td>
                                                        <td>{{ $detail->price }} &nbsp;{{ App\Http\Controllers\CountryController::getCurrency($order->rest_id) }}</td>
                                                    </tr>
                                                @endforeach
                                                <tr>
                                                    <td colspan="4"></td>
                                                    <td ><strong>{{ App\Http\Controllers\OrderController::getTotalOrder($order->id) }}&nbsp;{{ App\Http\Controllers\CountryController::getCurrency($order->rest_id) }}</strong></td></tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>



                                @if(Session::get('user_role')=='Branch Admin')

                                <div class="row no-print">
                                    <div class="col-xs-12">
                                        <a target="_blank" class="btn btn-success" href="{{ Route('order.print',['id'=>$order->id]) }}" ><i class="fa fa-print fa-lg"></i> <strong>Print</strong></a>
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
