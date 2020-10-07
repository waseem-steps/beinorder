@extends('layouts.master')

@section('content')
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
                        <h2>My Order Details </h2>
                        <a data-toggle="tooltip" data-placement="bottom" title="All Restaurants"
                            href="{{ Route('restaurants.active') }}"><i class="fa fa-eye"></i></a></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box table-responsive">
                                    <table id="datatable-responsive"
                                        class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                                        width="100%">
                                        <thead>
                                            <tr>
                                                <th></th>

                                                <th>Order Code</th>
                                                <th>Order Detail Date</th>
                                                <th>Description</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($order_details as $order_detail)
                                            <tr>
                                                <td></td>

                                                <td>{{ $order_detail->order->order_code }}</td>
                                                <td>{{ !empty($order_detail->created_at) ? $order_detail->created_at:'' }}
                                                </td>
                                               <td>{{ $order_detail->description }}</td>

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
<!-- /page content -->
@endsection
