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
                        <h2>الطاولة {{ $order->table_no }} - {{ $order->order_code }} - {{ $order->created_at }}</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <section class="content invoice">
                            <!-- title row -->
                            <div class="row">
                                <div class="col-xs-12 invoice-header">
                                    <h1><i class="fa fa-globe"></i> الفاتورة</h1>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- info row -->
                            <div class="row invoice-info">
                                <div class="col-sm-3 invoice-col">
                                    معلومات المطعم
                                    <address>
                                        <strong>{{ $order->rest_name }}</strong>
                                        <br>الطاولة: {{ $order->table_no }}
                                        <br><strong>@if($order->order_type==1)
                                            داخلي
                                            @else
                                            خارجي
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
                                    <b>معلومات الفاتورة</b>
                                    <br>
                                    <b>رقم الطلب:</b> {{ $order->order_code }}
                                    <br>
                                    <b>طريقة الدفع:</b> {{ $order->payment_method }}
                                    <br>
                                    <b>وقت الطلب:</b> {{ $order->created_at }}
                                    <br>
                                    <b>آخر تحديث:</b> {{ $order->updated_at }}
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
                                                <th style="width: 49%">الوصف</th>
												<th>الحالة</th>
                                                <th>الملاحظات</th>
                                                <th>الكمية</th>
                                                <th>السعر</th>
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
															{{ App\Http\Controllers\OrderHistoryController::getTableTotalOrderRestAdmin($order->table_id,$order->rest_id,Session::get('client_ip'),$order->order_code) }}&nbsp;{{ App\Http\Controllers\CountryController::getCurrency($order->rest_id) }}
														@endif
													</strong>
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
