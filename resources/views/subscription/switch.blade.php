@extends('layouts.master')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Select Plan Type</small></h3>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 text-center">
                <div class="col-md-6 text-center">
                    <div class="page-title">
                        <div class="title_left">
                            <div class="input-group">
                                <a type="button" class="btn btn-round btn-success" href="{{ Route('plans.index_internal') }}">
                                    <i class="fa fa-plus-circle"></i>
                                    Internal Subscription</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-center">
                    <div class="page-title">
                        <div class="title_left">
                            <div class="input-group">
                                <a type="button" class="btn btn-round btn-success" href="{{ Route('plans.index') }}">
                                    <i class="fa fa-plus-circle"></i>
                                    External Subscription</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
