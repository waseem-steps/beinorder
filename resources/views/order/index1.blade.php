@extends('layouts.master')

@section('content')
<script type="text/javascript">
    function autoRefreshPage()
    {
        window.location = window.location.href;
    }
    setInterval('autoRefreshPage()', 10000);
</script>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Orders Management</small></h3>

            </div>
        </div>

        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>My Orders </h2>
                        <a data-toggle="tooltip" data-placement="bottom" title="All Restaurants"
                            href="{{ Route('restaurants.active') }}"><i class="fa fa-eye"></i></a></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box table-responsive">
                                    <table id="datatable-responsive" class="table table-bordered dt-responsive nowrap"
                                        cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                @if(Session::get('user_role')=='Branch Admin')
                                                <th>Confirm</th>
                                                <th>Checkout</th>
                                                <th>Print</th>
                                                @endif

                                                <th>Order Code</th>
                                                <th>Order Status</th>
                                                <th>Payment Method</th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th>Details</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach($orders as $order)
                                            <tr>
                                                <td></td>
                                                <td>{{ $order->id }}</td>

                                                @if(Session::get('user_role')=='Branch Admin')
                                                <td>
                                                    @if($order->order_status_id==1)
                                                    <a href="{{Route('order.confirm',$order->id)  }}"><i
                                                            class="fa fa-cutlery"></i></a>
                                                    @endif

                                                </td>
                                                <td>
                                                    @if($order->order_status_id==2)
                                                    <a href="{{Route('order.checkout',$order->id)  }}"><i
                                                            class="fa fa-check"></i></a>
                                                    @endif
                                                </td>
                                                <td>
                                                    <button class="btn btn-success"
                                                        onclick="printDiv('dt_name{{ $order->id }}')"><i
                                                            class="fa fa-print"></i>Print</button>
                                                </td>

                                                @endif
                                                <td>{{ $order->order_code }}</td>
                                                <td>
                                                    @if($order->order_status_id==1)
                                                    Submitted
                                                    @endif
                                                    @if($order->order_status_id==2)
                                                    Preparing
                                                    @endif
                                                    @if($order->order_status_id==3)
                                                    Done
                                                    @endif</td>
                                                <td>{{ $order->payment_method }}</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <table>
                                                        <tr>
                                                            <td>

                                                                <table>
                                                                    <tr>
                                                                        <td colspan="2">Restaurant Information</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Restuarant Name</td>
                                                                        <td>{{ $order->rest_name }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Branch Name</td>
                                                                        <td>{{ $order->branch_name }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Payment Method</td>
                                                                        <td>{{ $order->payment_method }}</td>
                                                                    </tr>
                                                                </table>

                                                            </td>
                                                            <td>
                                                                <table>
                                                                    <tr>
                                                                        <td colspan="2">Car Information</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Customer Name</td>
                                                                        <td>{{ $order->customer_name }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Mobile</td>
                                                                        <td>{{ $order->phone_number }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Email</td>
                                                                        <td>{{ $order->customer_email }}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td colspan="2">Car Information</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Car Model</td>
                                                                        <td>{{ $order->car_type }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Car Color</td>
                                                                        <td>{{ $order->car_color }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>License Number</td>
                                                                        <td>{{ $order->li_number }}</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <table style="width:100%" class="table no-border"
                                                                  >
                                                                    <tr>
                                                                        <td colspan="2">Order Information</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Order Code</td>
                                                                        <td>{{ $order->order_code }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Order Time</td>
                                                                        <td>{{ $order->created_at }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Order Details</td>

                                                                        <td>@foreach(App\Http\Controllers\OrderDetailController::getDetails($order->id)
                                                                            as $detail)
                                                                            <p>{{ $detail->quantity }} x
                                                                                {{ $detail->description }}
                                                                                &nbsp;({{ $detail->price }})</p>
                                                                            <p>Notes: {{ $detail->notes }}</p>
                                                                            <br />

                                                                            @endforeach
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td id='dt_name{{ $order->id }}'>
                                                    <h1>@if($order->order_type==1)
                                                        Internal
                                                        @else
                                                        External
                                                    @endif</h1>
                                                    <p>Order Code: {{ $order->order_code }}</p>
                                                    <p>Order Time: {{ $order->created_at }}</p>
                                                    <p>--------------------------------------------------------</p>
                                                    <h3>Restaurant Information</h3>
                                                    <p>--------------------------------------------------------</p>
                                                    <p>Restaurant Name: {{ $order->rest_name }}</p>
                                                    <p>Branch Name: {{ $order->branch_name }}</p>
                                                    <p>Payment Method: {{ $order->payment_method }}</p>
                                                    <p>--------------------------------------------------------</p>
                                                    <h3>Customer Information</h3>
                                                    <p>--------------------------------------------------------</p>
                                                    <p>Customer Name: {{ $order->customer_name }}</p>
                                                    <p>Phone Number: {{ $order->phone_number }}</p>
                                                    <p>Email: {{ $order->customer_email }}</p>
                                                    <p>--------------------------------------------------------</p>
                                                    <h3>Car Information</h3>
                                                    <p>--------------------------------------------------------</p>
                                                    <p>Car Model: {{ $order->car_type }}</p>
                                                    <p>Car Color: {{ $order->car_color }}</p>
                                                    <p>License Number: {{ $order->li_number }}</p>
                                                    <p>--------------------------------------------------------</p>
                                                    <h3>Order Details</h3>
                                                    <p>--------------------------------------------------------</p>
                                                    @foreach(App\Http\Controllers\OrderDetailController::getDetails($order->id)
                                                    as $detail)
                                                    <p>{{ $detail->quantity }} x
                                                        {{ $detail->description }}
                                                        &nbsp;({{ $detail->price }})</p>
                                                    <p>Notes: {{ $detail->notes }}</p>
                                                    <br />
                                                    @endforeach
                                                    <p>--------------------------------------------------------</p>
                                                </td>
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

<iframe name="print_frame" width="0" height="0" frameborder="0" src="about:blank"></iframe>
<!-- /page content -->
<script>
    function printDiv(dt_name) {
    window.frames["print_frame"].document.body.innerHTML = document.getElementById(dt_name).innerHTML;
    window.frames["print_frame"].window.focus();
    window.frames["print_frame"].window.print();
    }

/* function printData()
{
var divToPrint=document.getElementById("order-dt");
newWin= window.open("");
newWin.document.write(divToPrint.outerHTML);
newWin.print();
newWin.close();
}

$('button').on('click',function(){
printData();
}) */
</script>
@endsection
