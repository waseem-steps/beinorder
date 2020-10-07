@extends('layouts.master-ar')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>الطاولات</small></h3>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 text-center">
                @foreach($tables as $table)
                <div class="col-md-55">
                    <div class="well profile_view"
                        style="padding: 10px; border-radius: 15px; border-color: #093120; border-width: 2px;">
                        <a href="#">
                            <div class="profile_img">

                                <img class="img-responsive avatar-view" style="width: 100%; border-radius: 15px;"
                                    src="{{ asset('images\table.png') }}" alt="image" />
                            </div>
                            <div class="caption"
                                style="height: 80px; border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;">
                                <p>رقم الطاولة: <strong>{{ $table->table_no }}</strong></p>
                                <p>اسم الكابتن: <strong>{{ $table->captin_name }}</strong></p>
                                <p>كود الطاولة: <strong>{{ $table->table_code }}</strong></p>
                            </div>
                            <div>
                                <p>
                                   {{--  <a data-toggle="tooltip" data-placement="bottom" title="Edit" href="#"><i
                                            class="fa fa-edit fa-2x"></i></a> --}}
                                    <a onclick="return confirm('هل أنت متأكد من حذف العنصر؟?');"
                                        data-toggle="tooltip" data-placement="bottom" title="حذف" href="{{ Route('table.delete-ar',$table->id) }}"><i
                                            class="fa fa-remove fa-2x"></i></a>
                                    <a data-toggle="tooltip" data-placement="bottom" title="QR عرض " href="{{ Route('restaurant.qrcode-ar',['rest_id'=>$table->rest_id,'table_id'=>$table->id]) }}"><i
                                            class="fa fa-qrcode fa-2x"></i></a>

                                </p>
                            </div>
                        </a>
                    </div>
                </div>
                @endforeach
                <div class="col-md-55">
                    <div class="well profile_view"
                        style="padding: 10px; border-radius: 15px; border-color: #093120; border-width: 2px;">
                        <button type="button" class="btn btn-round btn-success" data-toggle="modal" data-target=".bs-example-modal-lg">
                            <i class="fa fa-plus-circle"></i> طاولة جديدة
                        </button>
                        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">طاولة جديدة</h4>
                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="create-restaurant" data-parsley-validate class="form-horizontal form-label-left"
                                            action="{{ Route('table.store-ar') }}" method="POST" enctype="multipart/form-data">
                                            {{csrf_field()  }}
                                            <input type="hidden" name="rest_id" id="rest_id" value="{{ $id }}">
                                            <div class="item form-group">
                                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="table_no">رقم الطاولة<span
                                                        class="required">*</span>
                                                </label>
                                                <div class="col-md-6 col-sm-6 ">
                                                    <input type="text" id="table_no" name="table_no" required="required"
                                                        class="form-control ">
                                                </div>
                                            </div>
                                            <div class="item form-group">
                                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="captain_name">اسم الكابتن<span class="required">*</span>
                                                </label>
                                                <div class="col-md-6 col-sm-6 ">
                                                    <input type="text" id="captain_name" name="captain_name" required="required"
                                                        class="form-control ">
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                                                <button class="btn btn-danger" type="reset">محي</button>
                                                <button type="submit" class="btn btn-success">حفظ التغيرات</button>
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
    </div>
</div>
@endsection
