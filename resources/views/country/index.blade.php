@extends('layouts.master')

@section('content')
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Countries Management</small></h3>
            </div>
            {{--  <div class="title_right">
                            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search for...">
                                    <span class="input-group-btn">
                                        <button class="btn btn-secondary" type="button">Go!</button>
                                    </span>
                                </div>
                            </div>
                        </div> --}}
            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                    <div class="input-group">
                        <button type="button" class="btn btn-round btn-success" data-toggle="modal"
                            data-target=".bs-example-modal-lg"><i class="fa fa-plus-circle"></i> New
                            Country</button>

                        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">New Country</h4>
                                        <button type="button" class="close" data-dismiss="modal"><span
                                                aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="create-country" data-parsley-validate
                                            class="form-horizontal form-label-left" action="{{ Route('country.store')}}" method="POST"
                                            enctype="multipart/form-data">
                                            {{csrf_field()  }}
                                            <div class="item form-group">
                                                <label class="col-form-label col-md-3 col-sm-3 label-align"
                                                    for="country_name">Country Name<span class="required">*</span>
                                                </label>
                                                <div class="col-md-6 col-sm-6 ">
                                                    <input type="text" id="country_name" name="country_name"
                                                        required="required" class="form-control ">
                                                </div>
                                            </div>
                                            <div class="item form-group">
                                                <label class="col-form-label col-md-3 col-sm-3 label-align"
                                                    for="country_code">Country Code<span class="required">*</span>
                                                </label>
                                                <div class="col-md-6 col-sm-6 ">
                                                    <input type="text" id="country_code" name="country_code"
                                                        required="required" class="form-control ">
                                                </div>
                                            </div>
                                            <div class="item form-group">
                                                <label class="col-form-label col-md-3 col-sm-3 label-align"
                                                    for="country_currency">Country Currency<span
                                                        class="required">*</span>
                                                </label>
                                                <div class="col-md-6 col-sm-6 ">
                                                    <input type="text" id="country_currency" name="country_currency"
                                                        required="required" class="form-control ">
                                                </div>
                                            </div>
                                            <div class="item form-group">
                                                <label class="col-form-label col-md-3 col-sm-3 label-align"
                                                    for="currency_symbol">Currency Symbol<span class="required">*</span>
                                                </label>
                                                <div class="col-md-6 col-sm-6 ">
                                                    <input type="text" id="currency_symbol" name="currency_symbol"
                                                        required="required" class="form-control ">
                                                </div>
                                            </div>

                                            <div class="item form-group">
                                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="ar_country_name">Arabic Country Name<span
                                                        class="required">*</span>
                                                </label>
                                                <div class="col-md-6 col-sm-6 ">
                                                    <input type="text" id="ar_country_name" name="ar_country_name" required="required" class="form-control ">
                                                </div>
                                            </div>
                                            <div class="item form-group">
                                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="ar_country_code">Arabic Country Code<span
                                                        class="required">*</span>
                                                </label>
                                                <div class="col-md-6 col-sm-6 ">
                                                    <input type="text" id="ar_country_code" name="ar_country_code" required="required" class="form-control ">
                                                </div>
                                            </div>
                                            <div class="item form-group">
                                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="ar_country_currency">Arabic Country Currency<span
                                                        class="required">*</span>
                                                </label>
                                                <div class="col-md-6 col-sm-6 ">
                                                    <input type="text" id="ar_country_currency" name="ar_country_currency" required="required" class="form-control ">
                                                </div>
                                            </div>
                                            <div class="item form-group">
                                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="ar_currency_symbol">Arabic Currency Symbol<span
                                                        class="required">*</span>
                                                </label>
                                                <div class="col-md-6 col-sm-6 ">
                                                    <input type="text" id="ar_currency_symbol" name="ar_currency_symbol" required="required" class="form-control ">
                                                </div>
                                            </div>

                                            <div class="item form-group">
                                                <label class="col-form-label col-md-3 col-sm-3 label-align"
                                                    for="int_code">International Code<span class="required">*</span>
                                                </label>
                                                <div class="col-md-6 col-sm-6 ">
                                                    <input type="text" id="int_code" name="int_code" required="required"
                                                        class="form-control" value="+">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <button class="btn btn-danger" type="reset">Reset</button>
                                                <button type="submit" class="btn btn-success">Save
                                                    changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Available Countries </h2>
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
                                               {{--  <th></th> --}}
                                                <td>Country Name</td>
                                                <td>Country Code</td>
                                                <td>Country Currency</td>
                                                <td>Currency Symbol</td>
                                                <td>International Code</td>
                                                <th>Creation Date</th>
                                                <th>Last Update Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($countries as $country)
                                            <tr>
                                                <td></td>
                                               {{--  <td>
                                                    <a data-toggle="tooltip" data-placement="bottom" title="Delete"
                                                        href="{{ Route('country.delete',$country->id) }}"><i class="fa fa-remove"></i></a></td> --}}
                                                <td>{{$country->country_name}}</td>
                                                <td>{{$country->country_code}}</td>
                                                <td>{{$country->country_currency}}</td>
                                                <td>{{$country->currency_symbol}}</td>
                                                <td>{{$country->int_code}}</td>
                                                <td>{{$country->created_at}}</td>
                                                <td>{{$country->updated_at}}</td>
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
