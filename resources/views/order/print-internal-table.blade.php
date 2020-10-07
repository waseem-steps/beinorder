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
            
                @foreach($orders as $order)
				<div class="col-md-12 col-sm-12">
                <div class="x_panel" style="height: auto;" id='dt_name{{ $order->id }}'>
                    <div class="x_title">
                        <h2>Table {{ $order->table_no }}
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
                        </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <section class="content invoice">
                            <div class="row">
                                <div class="col-xs-12 invoice-header">
                                    <h1><i class="fa fa-globe"></i> Invoice</h1>
                                </div>
                            </div>
                            <div class="row invoice-info">
                                <div class="col-sm-12 invoice-col">
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
                            </div>
                            <div class="row">
							{{-- <div class="col-xs-12 table"> --}}
								<div class="col-sm-12">
								<div class="card-box table-responsive">
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
                                            @foreach(App\Http\Controllers\OrderController::getTableOrders($order->table_id,$order->rest_id,Session::get('client_ip'),$order->order_code) as $key =>$order1)
                                                @foreach(App\Http\Controllers\OrderDetailController::getDetails($order1->id)
                                                as  $detail)

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
                        </section>
                    </div>
                </div>
				</div>
                @endforeach
            
        </div>
    </div>
</div>

<script>
window.onload = function() { window.print(); }
</script>
</body>
</html>
