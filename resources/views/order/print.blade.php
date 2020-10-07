<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/ico" />

    <meta name="_token" content="{{ csrf_token() }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"
        integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css"
        crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha256-WqU1JavFxSAMcLP2WIOI+GB2zWmShMI82mTpLDcqFUg=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css"
        integrity="sha256-jKV9n9bkk/CTP8zbtEtnKaKf+ehRovOYeKoyfthwbC8=" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js"
        integrity="sha256-CgvH7sz3tHhkiVKh05kSUgG97YtzYNnWt6OXcmYzqHY=" crossorigin="anonymous"></script>

    <title>{{ config('app.name', 'Beinorder') }}</title>
    <!-- Bootstrap -->
    <link href="cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link href="{{ asset('css/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('css/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ asset('css/vendors/nprogress/nprogress.css') }}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{ asset('css/vendors/iCheck/skins/flat/green.css') }}" rel="stylesheet">
    <!-- Dropzone.js -->
    <link href="{{ asset('css/vendors/dropzone/dist/min/dropzone.min.css')}}" rel="stylesheet">
    <!-- Datatables -->
    <link href="{{ asset('css/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') }}"
        rel="stylesheet">
    <link href="{{ asset('css/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') }}"
        rel="stylesheet">
    <link href="{{ asset('css/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }}" rel="stylesheet">

    <!-- PNotify -->
    <link href="{{ asset('css/vendors/pnotify/dist/pnotify.css') }}" rel="stylesheet">
    <link href="{{ asset('css/vendors/pnotify/dist/pnotify.buttons.css') }}" rel="stylesheet">
    <link href="{{ asset('css/vendors/pnotify/dist/pnotify.nonblock.css') }}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{ asset('css/build/css/custom.min.css') }}" rel="stylesheet">
</head>

<body class="nav-md">
<div class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12">
                @foreach($orders as $order)
                <div class="x_panel" id='dt_name{{ $order->id }}'>
                    <div class="x_title">
                        <h2>{{ $order->order_code }} <small>@if($order->order_status_id==1)
                                Submitted
                                @endif
                                @if($order->order_status_id==2)
                                Preparing
                                @endif
                                @if($order->order_status_id==3)
                                Done
                                @endif</small>

                            @if($order->order_status_id==1)
                            <a href="{{Route('order.confirm',$order->id)  }}"><i class="fa fa-cutlery fa-lg"></i></a>
                            @endif

                            @if($order->order_status_id==2)
                            <a href="{{Route('order.checkout',$order->id)  }}"><i class="fa fa-check fa-lg"></i></a>
                            @endif

                        </h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <section class="content invoice">
                            <!-- title row -->
                            <div class="row">
                                <div class="col-xs-12 invoice-header">
                                    <h1>
                                        <i class="fa fa-globe"></i> Invoice.
                                        <small class="pull-right">Time: {{ $order->created_at }}</small>
                                    </h1>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- info row -->
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
                                <!-- /.col -->
                                <div class="col-sm-3 invoice-col">
                                    Customer Information
                                    <address>
                                        <strong>{{ $order->customer_name }}</strong>
                                        <br>{{ $order->phone_number }}
                                        <br>{{ $order->customer_email }}
                                    </address>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-3 invoice-col">
                                    Car Information
                                    <address>
                                        <strong>{{ $order->car_type }}</strong>
                                        <br>{{ $order->car_color }}
                                        <br>{{ $order->li_number }}
                                    </address>
                                </div>
                                <!-- /.col -->
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
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <!-- Table row -->


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
                                                <td>{{ $detail->price }}
                                                    &nbsp;{{ App\Http\Controllers\CountryController::getCurrency($order->rest_id) }}
                                                </td>
                                            </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="4"></td>
                                                <td><strong>{{ App\Http\Controllers\OrderController::getTotalOrder($order->id) }}&nbsp;{{ App\Http\Controllers\CountryController::getCurrency($order->rest_id) }}</strong>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </section>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>
</div>

<script>
window.onload = function() { window.print(); }
</script>
</body>
</html>
