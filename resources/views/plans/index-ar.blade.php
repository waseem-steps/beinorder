@extends('layouts.master-ar')

@section('content')
<!-- page content -->
<div class="right_col" role="main" style="background-color: #fff;">
        <div class="page-title">
            <div class="title_left">
                <h3>الأسعار</h3>
            </div>

            @if(Session::get('user_role')=='Administrator')
            <div class="title_right">
				<div class="input-group">
                    <button type="button" class="btn btn-round btn-success" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-plus-circle"></i> New Plan</button>
                    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel">خطة جديدة</h4>
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="create-product" data-parsley-validate class="form-horizontal form-label-left"
                                        action="{{ Route('plan.store-ar') }}" method="POST" enctype="multipart/form-data">
                                        {{csrf_field()  }}

                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="plan_name">اسم الخطة<span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 ">
                                                <input type="text" id="plan_name" name="plan_name" required="required"
                                                    class="form-control ">
                                            </div>
                                        </div>

                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="ar_plan_name">الاسم العربي<span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 ">
                                                <input type="text" id="ar_plan_name" name="ar_plan_name" required="required" class="form-control ">
                                            </div>
                                        </div>

                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="period">المدة<span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 ">
                                                <input type="text" id="period" name="period" required="required" class="form-control " placeholder="Period in days">
                                            </div>
                                        </div>

                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="price">السعر<span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 ">
                                                <input type="text" id="price" name="price" required="required" class="form-control ">
                                            </div>
                                        </div>

                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="branch_count">عدد الفروع<span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 ">
                                                <input type="text" id="branch_count" name="branch_count" required="required" class="form-control ">
                                            </div>
                                        </div>

                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="plan_type">نوع الخطة<span
                                                    class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 ">
                                                <input type="radio" name="plan_type" class="flat" value="0" checked>
                                                خارجي
                                                <input type="radio" name="plan_type" class="flat" value="1">
                                                داخلي
                                            </div>
                                        </div>

                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="country_id">الدولة<span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 ">
                                                <select class="form-control" id="country_id" name="country_id" required="required">
                                                    @foreach(App\Http\Controllers\CountryController::getCountries() as $country)
                                                    <option value="{{ $country->id }}">
                                                        {{  $country->ar_country_name }}
                                                    </option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                                            <button type="submit" class="btn btn-success">حفظ التغيرات</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
			</div>

            @endif

        </div>
		<div class="clearfix">
		</div>
        <div class="row">
            <div class="col-md-12 col-sm-12  ">
                <div class="x_panel" style="border: 0px;">
                    <div class="x_content">
                                <!-- price element -->
                                @foreach($plans as $plan)
                                    <div class="col-md-3">
                                        <div class="pricing">
                                            <div class="title">
                                                <h2>{{ $plan->plan_name }}
													@if(Session::get('user_role')=='Administrator')
														<a href="{{ Route('plan.toggle-status-ar',$plan->id) }}">
															@if($plan->status == 0)
																<i class="fa fa-unlock"></i>
																@else
																<i class="fa fa-lock"></i>
															@endif
														</a>
													@endif
												</h2>
                                                <h1>{{ $plan->price }} {{ $plan->country->currency_symbol}}</h1>
                                                <span>
                                                    @if($plan->period==7)
                                                        أسبوعي
                                                    @elseif($plan->period==30)
                                                        شهري
                                                    @elseif($plan->period==120)
                                                        ربع سنوي
                                                    @elseif($plan->period==180)
                                                        نصف سنوي
                                                    @elseif($plan->period==365)
                                                        سنوي
                                                    @else
                                                        {{  $plan->period}} days
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="x_content">
                                                    <div class="pricing_features">
                                                        <ul class="list-unstyled text-left">
                                                            <li>Total Branches: {{ $plan->branch_count }}</li>
                                                            <li>Period: {{ $plan->period }} day(s)</li>
                                                        </ul>
                                                    </div>
                                                <div class="pricing_footer">
                                                    <a href="{{ route('plan.subscribe',['id'=>$plan->id]) }}" class="btn btn-success btn-block" role="button">Subscribe<span> Now!</span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <!-- price element -->
                    </div>
                </div>
            </div>
        </div>
</div>
<!-- /page content -->
@endsection
