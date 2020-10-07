@extends('layouts.master-ar')

@section('content')
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>إدارة الاشتراكات</small></h3>
            </div>
        </div>

        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>تحديث</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
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
                                                <th></th>
                                                <th>اسم المطعم</th>
                                                <th>الخطة الحالية</th>
                                                <th>الخطة الجديدة</th>
                                                <th>تاريخ البداية</th>
                                                <th>تاريخ النهاية</th>
                                              <th>الحالة</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($all as $sub)
                                            <tr>
                                                <td></td>
                                                <td><a href="{{ Route('plan.activate-ar',['id'=>$sub->id,'rest_id'=>$sub->rest_id]) }}"><i class="fa fa-check"></i></a></td>
                                                <td>{{ $sub->ar_rest_name }}</td>
                                                <td>{{ $sub->ar_current_plan }}</td>
                                                <td>{{ $sub->ar_next_plan }}</td>
                                                <td>{{ $sub->ar_status }}</td>
                                                <th>{{ $sub->start_date }}</th>
                                                <th>{{ $sub->end_date }}</th>
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
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>فعال</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box table-responsive">
                                    <table id="datatable-responsive1"
                                        class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                                        width="100%">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>اسم المطعم</th>
                                                <th>الخطة الحالية</th>
                                                <th>الخطة الجديدة</th>
                                                <th>تاريخ البداية</th>
                                                <th>تاريخ النهاية</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($all_actv as $sub)
                                            <tr>
                                                <td></td>

                                                <td>{{ $sub->ar_rest_name }}</td>
                                                <td>{{ $sub->ar_current_plan }}</td>
                                                <td>{{ $sub->ar_next_plan }}</td>
                                                <td>{{ $sub->ar_status }}</td>
                                                <th>{{ $sub->start_date }}</th>
                                                <th>{{ $sub->end_date }}</th>
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
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>القديم</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box table-responsive">
                                    <table id="datatable-responsive 2"
                                        class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                                        width="100%">
                                        <thead>
                                            <tr>
                                                <th></th>

                                                <th>اسم المطعم</th>
                                                <th>الخطة الحالية</th>
                                                <th>الخطة الجديدة</th>
                                                <th>تاريخ البداية</th>
                                                <th>تاريخ النهاية</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($all_subs as $sub)
                                            <tr>
                                                <td></td>

                                                <td>{{ $sub->ar_rest_name }}</td>
                                                <td>{{ $sub->ar_current_plan }}</td>
                                                <td>{{ $sub->ar_next_plan }}</td>
                                                <td>{{ $sub->ar_status }}</td>
                                                <th>{{ $sub->start_date }}</th>
                                                <th>{{ $sub->end_date }}</th>
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

